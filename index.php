<?php
    $tenantId = '9af6539b-6aeb-41ad-ace8-09269beb7a40';
    $clientId = '2a0b6a5f-e396-4283-96d3-6dedc202b1b3';
    $clientSecret = "saqdEYMQ57-kvvBMB742_@?";

    require 'vendor/autoload.php';

    $guzzle = new \GuzzleHttp\Client();
    $url = 'https://login.microsoftonline.com/' . $tenantId . '/oauth2/token?api-version=1.0';
    $token = json_decode($guzzle->post($url, [
            'form_params' => [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'resource' => 'https://graph.microsoft.com/',
            'grant_type' => 'client_credentials',
        ],
    ])->getBody()->getContents());
    $accessToken = $token->access_token;

    use Microsoft\Graph\Graph;
    use Microsoft\Graph\Model;


    $graph = new Graph();
    $graph->setAccessToken($accessToken);


    /*
    $groups = $graph->createRequest("GET", "/groups?\$top=999")
                    ->setReturnType(Model\Group::class)
                    ->execute();
    */


    $groupsGrabber = $graph->createCollectionRequest("GET", "/groups")
                            ->setReturnType(Model\Group::class)
                            ->setPageSize(999);

    $groups = $groupsGrabber->getPage();


    foreach($groups as $group)
    {
        $groupTypes[] = $group->getSecurityEnable();
    }
    sort($groups);
    /*
    while(!$groupsGrabber->isEnd())
    {
        $groups = array_merge($groups,$groupsGrabber->getPage());
    }
    */

    $count=1;
    foreach($groups as $group)
    {
        //echo $count . " - " . $group->getDisplayName() . " - " . $group->getGroupTypes() . "<br>";
        echo $count . " - " . $group->getDisplayName() . "<br>";
        $count++;
    }

    /*
    $count = 1;
    foreach($groups as $group)
    {
        echo $count . " - " . $group->getDisplayName() . "<br>";
        $count++;
    }
    */
    //print_r($groups[1]);
?>