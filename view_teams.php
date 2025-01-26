<?php
// Database connection
$connection = mysqli_connect("localhost", "root", "", "team");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all teams
$query_teams = "SELECT * FROM teams";
$result_teams = mysqli_query($connection, $query_teams);

if (!$result_teams) {
    die("Error fetching teams: " . mysqli_error($connection));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Teams</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Global Styles */
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px;
        }

        .back-btn {
            display: inline-block;
            margin-bottom: 30px;
            padding: 12px 20px;
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
            text-decoration: none;
            border-radius: 5px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .back-btn:hover {
            background-color: #45a049;
            box-shadow: 0 6px 8px rgba(0, 0, 0, 0.2);
        }

        /* Team Table Styles */
        .teams-container {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .team-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .team-table th, .team-table td {
            padding: 15px;
            text-align: left;
            font-size: 16px;
        }

        .team-table th {
            background-color: #007bff;
            color: white;
            font-weight: 500;
            letter-spacing: 1px;
        }

        .team-table td {
            background-color: #f9f9f9;
            color: #333;
        }

        .team-table tr:nth-child(even) td {
            background-color: #f1f1f1;
        }

        .team-table tr:hover td {
            background-color: #e0e0e0;
        }

        .team-table .member-name {
            font-weight: 500;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .team-table .member-name:hover {
            color: #0056b3;
            text-decoration: underline;
        }

        .team-table .member-profile {
            font-style: italic;
            color: #555;
        }

        .team-table .member-skills {
            font-weight: 400;
            color: #777;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .team-table th, .team-table td {
                font-size: 14px;
                padding: 10px;
            }

            .back-btn {
                font-size: 14px;
                padding: 10px 15px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Back Button -->
    <a href="create_team.php" class="back-btn">Back</a>

    <div class="teams-container">

        <?php
        // Loop through each team
        while ($team = mysqli_fetch_assoc($result_teams)) {
            $team_id = $team['team_id'];
            $team_name = $team['team_name'];

            echo '<table class="team-table">';
            echo '<thead>';
            echo "<tr><th colspan='3' class='team-name'>$team_name</th></tr>"; // Team name as header
            echo "<tr><th>Member Name</th><th>Profile</th><th>Skills</th></tr>";
            echo '</thead>';
            echo '<tbody>';

            // Fetch team members for each team
            $query_team_members = "SELECT * FROM team_members tm 
                                   JOIN team_details td ON tm.username = td.member_username
                                   WHERE td.team_id = $team_id";
            $result_team_members = mysqli_query($connection, $query_team_members);

            if (!$result_team_members) {
                die("Error fetching team members: " . mysqli_error($connection));
            }

            // Loop through each team member and display their details
            while ($member = mysqli_fetch_assoc($result_team_members)) {
                $member_name = $member['name'];
                $member_profile = $member['profile'];
                $member_skills = $member['skills'];

                echo "<tr>
                        <td><a href='#' class='member-name'>$member_name</a></td>
                        <td class='member-profile'>$member_profile</td>
                        <td class='member-skills'>$member_skills</td>
                    </tr>";
            }

            echo '</tbody>';
            echo '</table>';
        }
        ?>

    </div>
</div>

<?php
mysqli_close($connection);
?>

</body>
</html>
