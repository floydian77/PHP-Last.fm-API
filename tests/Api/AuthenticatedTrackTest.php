<?php

namespace Tests\Api;

use LastFmApi\Api\TrackApi;

/**
 * Description of AuthenticatedTrackTest
 *
 * @author Marcos Peña
 */
class AuthenticatedTrackTest extends BaseAuthenticatedApiTest
{

    private $trackApi;
    const TRACK_NAME = 'When I get the time';
    const ARTIST_NAME = 'Descendents';
    
    public function __construct($name = null, array $data = array(), $dataName = '')
    {
        if (!$this->isApiInitiated()) {
            $this->initiateApi();
        }
        parent::__construct($name, $data, $dataName);
        $this->trackApi = new TrackApi($this->authentication);
    }    

    public function testLoveTrack()
    {
        $loved = $this->trackApi->love(array(
            'artist' => self::ARTIST_NAME,
            'track' => self::TRACK_NAME
        ));
        
        $this->assertTrue($loved);
    }
    
    public function testUnloveTrack()
    {
        $result = $this->trackApi->unlove(array(
            'track' => self::TRACK_NAME,
            'artist' => self::ARTIST_NAME)
        );

        $this->assertTrue($result);        
    }    
    
    public function testScrobbleASingleTrack()
    {
        $result = $this->trackApi->scrobble(array(
            'artist' => self::ARTIST_NAME,
            'track' => self::TRACK_NAME,
            'timestamp' => time()
            )
        );

        $this->assertTrue($result);        
    }

    public function testScrobbleABatchOfTracks()
    {
        $result = $this->trackApi->scrobble(array(
            'artist[0]' => self::ARTIST_NAME,
            'track[0]' => self::TRACK_NAME,
            'timestamp[0]' => time() - 180,
            'artist[1]' => self::ARTIST_NAME,
            'track[1]' => self::TRACK_NAME,
            'timestamp[1]' => time(),
            )
        );

        $this->assertTrue($result);
    }
}
