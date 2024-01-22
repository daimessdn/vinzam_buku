<?php
function showLastFiveMembers($conn)
{
    $members = $conn->query("SELECT * FROM anggota ORDER BY id DESC LIMIT 5;");
    $members_result = $members->fetchAll(PDO::FETCH_ASSOC);

    return $members_result;
}
