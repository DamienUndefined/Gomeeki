<?php

namespace Gomeeki\Bundle\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gomeeki\Bundle\CoreBundle\Entity\Location;
use Gomeeki\Bundle\CoreBundle\Entity\History;

class SearchController extends Controller
{

    /**
     * @param $locationName
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction($locationName)
    {
        $session = $this->get('session');
        $session->start();

        $locationManager = $this->get('location_manager');
        $location = $locationManager->findByName($locationName);

        // if location doesn't exist, we create a row into the db
        if(!$location) {
            $curl     = new \Ivory\HttpAdapter\CurlHttpAdapter();
            $geocoder = new \Geocoder\Provider\GoogleMaps($curl);
            $geocodes = $geocoder->geocode($locationName)->first();
            $location = Location::createLocation(
                                $locationName,
                                $geocodes->getLongitude(),
                                $geocodes->getLatitude()
                            );
            $locationManager->saveLocation($location);
        }

        // add location to the current user history
        $history = new History($session->getId(), $location);
        $this->get('history_manager')->saveHistory($history);

        $tweetManager = $this->get('tweet_manager');
        if($location->useCache($this->container->getParameter('twitter_refresh'))) {
            //get tweets from db
            $tweetList = $tweetManager->findBy(array('location' => $location));
            $tweetList = $this->formatTweets($tweetList);
        } else {
            // get tweets from TwitterApi
            $tweetList = $this->get('tweet_manager')->getTweets(
                                        $this->get('endroid.twitter'),
                                        $location,
                                        $this->container->getParameter('twitter_radius')
                                    );

            // insert tweetList
            $tweetManager->insertTweetList($tweetList, $location);

            // update the location with the last search datetime
            $location->setLastSearch(new \DateTime());
            $locationManager->saveLocation($location);
        }

        return $this->render('GomeekiCoreBundle:Front:search.html.twig', array('location' => $location, 'tweetList' => $tweetList));
    }

    /**
     * @param $tweetList
     * @return array
     * Format tweets to be easily readable in the view
     */
    private function formatTweets($tweetList)
    {
        $formatedTweetList = array();
        foreach($tweetList as $tweet) {
            $formatedTweet = array();
            $formatedTweet['user']['name'] = $tweet->getUser();
            $formatedTweet['user']['profile_image_url'] = $tweet->getImgUrl();
            $formatedTweet['text'] = $tweet->getContent();
            $formatedTweet['created_at'] = $tweet->getDatePost();
            $formatedTweet['geo']['coordinates'][0] = $tweet->getLatitude();
            $formatedTweet['geo']['coordinates'][1] = $tweet->getLongitude();
            array_push($formatedTweetList, $formatedTweet);
        }
        return $formatedTweetList;
    }
}
