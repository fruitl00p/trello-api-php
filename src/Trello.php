<?php

namespace Kingsquare\Trello;

/**
 *
 */
abstract class Trello
{
    protected $curl;
    private $key;
    private $token;
    private $apiUrl = 'https://api.trello.com/';
    private $apiVersion = '1';

    /**
     * Construct a Trello API Object
     * @param string $key Trello Developer Key
     * @param string $token User token
     */
    function __construct($key, $token)
    {
        $this->key = $key;
        $this->token = $token;

        $this->curl = new Curl();
    }

    /**
     * Does a GET request to Trello API
     * @param string $collectionId ID of item.
     * @param string $complement Complement of the URL. Will be placed after ID
     * @param array $arguments Arguments to be passed as queryString to API
     * @return object                The response from Trello API
     */
    public function get($collectionId, $complement = '', $arguments = [])
    {
        $authParam = $this->getAuthParam();
        $url = $this->getUrl();

        $argumentsParam = '';
        if (!empty($arguments)) {
            $argumentsParam = '&' . http_build_query($arguments);
        }

        $this->curl->get($url . $this->collection . '/' . $collectionId . '/' . $complement . $authParam . $argumentsParam);
        $this->id = $this->curl->response->id;
        return $this->curl->response;
    }

    /**
     * Mount queryString for API Calls
     * @return string QueryString for the calls
     */
    protected function getAuthParam()
    {
        return '?key=' . $this->key . '&token=' . $this->token;
    }

    /**
     * Mount the URL for the Trello APO
     * @return string URL for the API
     */
    protected function getUrl()
    {
        return $this->apiUrl . $this->apiVersion . '/';
    }

    /**
     * Does a POST request to Trello API
     * @param array $data Data to be sent to Trello
     * @param string $complement Complement of the URL. Will be placed after collection or ID
     * @param string $collectionId ID of item. It's useful, for example, to post new comments
     * @return object                The response from Trello API
     */
    public function post($data, $complement = '', $collectionId = '')
    {
        $authParam = $this->getAuthParam();
        $url = $this->getUrl();

        $call = $this->collection . '/';
        if ($collectionId) {
            $call .= $collectionId . '/';
        }
        $call .= $complement . $authParam;

        $this->curl->post($url . $call, $data);
        return $this->curl->response;
    }

    /**
     *  Does a PUT request to Trello API
     * @param string $collectionId ID of item to be putted
     * @param array $data Data to be putted
     * @param string $complement Complement to the API. For example, the action
     * @return object               The response from Trello API
     */
    public function put($collectionId, $data, $complement = '')
    {
        $authParam = $this->getAuthParam();
        $url = $this->getUrl();
        $rs = $this->curl->put($url . $this->collection . '/' . $collectionId . '/' . $complement . $authParam,
            $data);
        return $this->curl->response;
    }

    /**
     * Does a DELETE request to Trello API
     * @param string $collectionId ID of item to be deleted
     * @param string $complement Complement of the URL. Will be placed after collection or ID
     * @return object               The response from Trello API
     */
    public function delete($collectionId = '', $complement = '')
    {
        $authParam = $this->getAuthParam();
        $url = $this->getUrl();

        $this->curl->delete($url . $this->collection . '/' . $collectionId . '/' . $complement . $authParam);
        return $this->curl->response;
    }
}
