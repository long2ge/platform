<?php

namespace App;

use ScoutElastic\SearchRule;

class MySearchRule extends SearchRule
{
    // This method returns an array, describes how to highlight the results.
    // If null is returned, no highlighting will be used.
    public function buildHighlightPayload()
    {
        return [
            'fields' => [
                'request_method' => [
                    'type' => 'plain'// 返回高亮
                ]
            ]
        ];
    }

    // This method returns an array, that represents bool query.
    public function buildQueryPayload()
    {
        return [
            'must' => [
//                'match' => [
//                    'request_method' => 'POST'
//                ],
                'query_string' => [
                    'query' => $this->builder->query, // MyModel::search('POST') = $this->builder->query == POST
                ],
            ]
        ];
    }

}