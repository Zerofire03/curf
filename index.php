<?php
    include 'dbconnect.php';
    require 'vendor/autoload.php';
    use Microsoft\Graph\Graph;
    use Microsoft\Graph\Model;

    $conn = getDBConnection();


    //Create access token used for authentication
    function getAccessToken()
    {
        $tenantId = '9af6539b-6aeb-41ad-ace8-09269beb7a40';
        $clientId = '2a0b6a5f-e396-4283-96d3-6dedc202b1b3';
        $clientSecret = "saqdEYMQ57-kvvBMB742_@?";

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
        return $token->access_token;
    }


    //Gets the employment types from the db and displays them as options
    function getEmploymentTypes()
    {
        global $conn;
        //SQL to return employment types in DB
        $sql = "SELECT * FROM employmenttype";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $employmentTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach($employmentTypes as $type)
        {
            echo "<option value=" . $type['type'] . ">" . $type['type'] . "</option>";
        }
    }

    function getDistributionGroups()
    {
        //Create graph object and set access token
        $graph = new Graph();
        $graph->setAccessToken(getAccessToken());

        //Create request for API call
        $groupsGrabber = $graph->createCollectionRequest("GET", "/groups?\$filter=mailEnabled eq true and securityEnabled eq false")
                            ->setReturnType(Model\Group::class)
                            ->setPageSize(999);

        $groups = $groupsGrabber->getPage();

        //
        foreach($groups as $group)
        {
            $groupsArray[] = $group->getDisplayName();
        }

        sort($groupsArray);

        foreach($groupsArray as $group)
        {
            echo "<input type='checkbox'>" . $group . "<br>";
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>CURF Form</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <script
            src="https://code.jquery.com/jquery-3.3.1.js"
            integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
            crossorigin="anonymous">
        </script>
    </head>
    <body>
        <div id="curf">
            <form id="userInfo">
                <div class="userInfo">
                    <h1>User Information:</h1>
                    <div class="firstName">
                        <label>
                            First Name<span style="color: red">*</span>
                            <input type="text" name="firstName" id="firstName">
                        </label>
                    </div>
                    <div class="middleName">
                        <label>
                            Middle Name
                            <input type="text" name="middleName" id="middleName">
                        </label>
                    </div>
                    <div class="lastName">
                        <label>
                            Last Name<span style="color: red">*</span>
                            <input type="text" name="lastName" id="lastName">
                        </label>
                    </div>
                    <div class="workingTitle">
                        <label>
                            Working Title<span style="color: red">*</span>
                            <input type="text" name="workingTitle" id="workingTitle">
                        </label>
                    </div>
                    <div class="startDate">
                        <label>
                            Start Date<span style="color: red">*</span>
                            <input type="date" name="startDate" id="startDate">
                        </label>
                    </div>
                    <div class="employmentType">
                        <label>
                            Employment Type<span style="color: red">*</span>
                            <select name="employmentType">
                                <option></option>
                                <?php getEmploymentTypes() ?>
                            </select>
                        </label>
                    </div>
                    <div class="specialInstructions">
                        <label>
                            Special Instructions
                            <input type="text" name="specialInstructions" id="specialInstructions">
                        </label>
                    </div>
                </div>
                <div class="departmentInfo">
                    <br>
                    <h1>Department Information:</h1>
                    <div class="departmentName">
                        <label>
                            Department Name<span style="color: red">*</span>
                            <select name="departmentName">
                                <option></option>
                                <option>Insert function to pull from AD</option>
                            </select>
                        </label>
                    </div>
                    <div class="supervisor">
                        <label>
                            Supervisor<span style="color: red">*</span>
                            <select name="supervisor">
                                <option></option>
                                <option>Insert function to pull from AD</option>
                            </select>
                        </label>
                    </div>
                    <div class="phoneNumber">
                        <label>
                            Phone Number
                            <input type="text" name="phoneNumber" id="phoneNumber">
                        </label>
                    </div>
                    <div class="roomNumber">
                        <label>
                            Room Number<span style="color: red">*</span>
                            <input type="text" name="roomNumber" id="roomNumber">
                        </label>
                    </div>
                </div>
                <div class="d1Information">
                    <br>
                    <h1>D1 Information:</h1>
                    <p>Decide on D1 stuff to put here and fill in</p>
                </div>
                <div class="emailInformation">
                    <br>
                    <h1>Email Information:</h1>
                    <div class="distributionGroups">
                        Distribution Groups:<br>
                        <span>Select Distribution Groups...</span><br>
                        <?php getDistributionGroups(); ?>
                    </div>
                </div>
                </div>
            </form>
        </div>
    </body>
</html>