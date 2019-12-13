<?php

namespace Kingsquare\Trello;

/**
 *
 * API Reference: https://developers.trello.com/advanced-reference/list
 */
class ListCollection extends Trello
{
    /**
     * The string of collection on Trello API.
     * Will be used to generate the URLs for requests.
     * @var string
     */
    public $collection = 'list';

    public $id = '';

    /**
     * Archive a Trello List
     * @param string $listID ID of the list that will be archived
     * @return object            Response of Trello API
     */
    public function archive($listID)
    {
        $data = ['value' => true];
        $this->put($listID, $data, 'closed');
        return $this->curl->response;
    }

    /**
     * Remove a Trello List from Archive to your last list
     * @param string $listID ID of the list that will be removed from archive
     * @return object            Response of Trello API
     */
    public function unarchive($listID)
    {
        $data = ['value' => false];
        $this->put($listID, $data, 'closed');
        return $this->curl->response;
    }

    /**
     * @param string $listID
     * @param string $boardID
     * @param string $position
     */
    public function moveToBoard($listID, $boardID, $position = '')
    {
        $data = ['value' => $boardID];
        if (!empty($position)) {
            $data['pos'] = $position;
        }
        $this->put($listID, $data, 'idBoard');
    }
}
