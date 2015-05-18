<?php

namespace Gomeeki\Bundle\CoreBundle\Manager;

use Doctrine\ORM\EntityManager;
use Gomeeki\Bundle\CoreBundle\Manager\BaseManager;
use Gomeeki\Bundle\CoreBundle\Entity\Tweet;

class TweetManager extends BaseManager
{
    protected $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @param $criteria
     * @return array
     * Find a list of Tweets with matching criteria
     */
    public function findBy($criteria)
    {
        return $this->getRepository()->findBy($criteria);
    }

    /**
     * @param $twitterApi
     * @param $location
     * @param $radius
     * @param int $tweetsMax
     * @return array
     * @throws \Exception
     * Return a list of tweets from TwitterApi with the requested params (location, geocode...)
     */
    public function getTweets($twitterApi, $location, $radius, $tweetsMax = 50)
    {
        // query sent to twitter API
        $query = array(
            'q' => $location->getName().' OR #' . $location->getName(), 'max_results' => $tweetsMax,
            'geocode' => $location->getLatitude() .','. $location->getLongitude() .','.$radius, 'count' => $tweetsMax
        );

        $response = $twitterApi->query('search/tweets', 'GET', 'json', $query);

        if(!$response->isSuccessful()) {
            // Here we should add logs and error handling
            throw new \Exception('Error from Twitter API');
        }

        $results = json_decode($response->getContent(), true);

        $tweetList = array();
        foreach ($results['statuses'] as $tweet) {
            // only get tweets with coordinates
            if (isset($tweet['coordinates'])) {
                array_push($tweetList, $tweet);
            }
        }

        return $tweetList;
    }

    /**
     * @param $tweetList
     * @param $location
     * Insert a tweet collection into the db
     */
    public function insertTweetList($tweetList, $location)
    {
        foreach($tweetList as $tweet) {
            $mytweet = new Tweet();
            $mytweet->setContent($tweet['text'])
                ->setUser($tweet['user']['name'])
                ->setDatePost($tweet['created_at'])
                ->setImgUrl($tweet['user']['profile_image_url'])
                ->setLongitude($tweet['geo']['coordinates'][1])
                ->setLatitude($tweet['geo']['coordinates'][0])
                ->setLocation($location);
            $this->persistTweet($mytweet);
        }

        // insert the collection into the db
        $this->flushTweetCollection();
    }

    public function persistTweet(Tweet $tweet)
    {
        $this->em->persist($tweet);
    }

    public function flushTweetCollection()
    {
        try {
            $this->em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            // Here we should add logging and error handling
        }
    }

    public function saveTweet(Tweet $tweet)
    {
        $this->persistAndFlush($tweet);
    }

    public function getRepository()
    {
        return $this->em->getRepository('GomeekiCoreBundle:Tweet');
    }

}