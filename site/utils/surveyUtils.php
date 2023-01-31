<?php function getAnswers($questionId)
{
    $mysqli = new mysqli("db", "user", "password", "appDB");
    $answers = $mysqli->prepare("SELECT * FROM survey_answers WHERE idQuestion=?");
    $answers->bind_param('i', $questionId);
    $answers->execute();
    $answersResult = $answers->get_result();
    //$answerRow = $answersResult->fetch_assoc();
    foreach ($answersResult as $row) {
        //var_dump($row);
        $summary = $row['answer1'] + $row['answer2'] + $row['answer3'] + $row['answer4'] + $row['answer5'];
        $summary = max($summary, 1);
        $percentage1 = ($row['answer1'] * 100) / $summary;
        $percentage2 = ($row['answer2'] * 100) / $summary;
        $percentage3 = ($row['answer3'] * 100) / $summary;
        $percentage4 = ($row['answer4'] * 100) / $summary;
        $percentage5 = ($row['answer5'] * 100) / $summary;
        echo "<table>";
        echo "<tr> <th><p>Очень плохо</p></th> <th>{$row['answer1']}</th> <th>$percentage1 %</th> </tr>";
        echo "<tr> <th><p>Плохо</p></th> <th>{$row['answer2']}</th> <th>$percentage2 %</th> </tr>";
        echo "<tr> <th><p>Удовлетворительно</p></th> <th>{$row['answer3']}</th> <th>$percentage3 %</th> </tr>";
        echo "<tr> <th><p>Хорошо</p></th> <th>{$row['answer4']}</th> <th>$percentage4 %</th> </tr>";
        echo "<tr> <th><p>Отлично</p></th> <th>{$row['answer5']}</th> <th>$percentage5 %</th> </tr>";
        echo "</table>";
    }
    $mysqli->close();
}

function makeOwnResults() {
    $flag = false;
    $mysqli = new mysqli("db", "user", "password", "appDB");
    $mysqli->set_charset("utf-8");
    $author = $_SESSION['name'];
    $result = $mysqli->query("SELECT * FROM survey_questions WHERE creator='$author'");
    $curSurvey = 0;
    foreach ($result as $row) {
        echo "<br>";
        if ($row['idSurvey'] != $curSurvey) {
            if ($flag)
                echo "</div></div>";
            $flag = true;
            echo "<div>";
            echo "<h1 class='survey'>{$row['surveyName']}</h1>";
            echo "<button class='interaction' id=$curSurvey onclick='myFunction(this.id)'>Показать/скрыть</button>";
            echo "<div id=$curSurvey style='display: none;'>";
            $curSurvey += 1;
        }
        echo "<p>{$row['questionBody']}</p>";
        getAnswers($row['idQuestion']);
    }
    $mysqli->close();
}

function makeResults()
{
    $flag = false;
    $mysqli = new mysqli("db", "user", "password", "appDB");
    $mysqli->set_charset("utf-8");
    $result = $mysqli->query("SELECT * FROM survey_questions");
    $curSurvey = 0;
    foreach ($result as $row) {
        echo "<br>";
        if ($row['idSurvey'] != $curSurvey) {
            if ($flag)
                echo "</div></div>";
            $flag = true;
            echo "<div>";
            echo "<h1 class='survey'>{$row['surveyName']}</h1>";
            echo "<button class='interaction' id=$curSurvey onclick='myFunction(this.id)'>Показать/скрыть</button>";
            echo "<div id=$curSurvey style='display: none;'>";
            $curSurvey += 1;
        }
        echo "<p>{$row['questionBody']}</p>";
        getAnswers($row['idQuestion']);
    }
    $mysqli->close();
}


function showPreview()
{
    $mysqli = new mysqli("db", "user", "password", "appDB");
    $mysqli->set_charset("utf-8");
    $result = $mysqli->query("SELECT DISTINCT surveyName, idSurvey FROM survey_questions");
    foreach ($result as $row) {
        echo "<div class='preview'>";
        $idSur = $row['idSurvey'];
        settype($idSur, "int");
        echo "<a href='survey.php?id=$idSur'";
        echo "<h1>{$row['surveyName']}</h1>";
        echo "</a>";
        echo "</div>";
    }
    $mysqli->close();
}

function showSurvey($id)
{
    $mysqli = new mysqli("db", "user", "password", "appDB");
    $mysqli->set_charset("utf-8");
    $name = utf8_encode($_SESSION['name']);
    $id = utf8_encode($id);
    $getAccess = $mysqli->query('SELECT * FROM completed_surveys');
    foreach ($getAccess as $row) {
        if ($row['username'] == $name && $row['idSurvey'] == $id) {
            echo "<script> alert('Вы уже поучаствовали в опросе') </script>";
            echo "<script> location.href='main.php'; </script>";
        }
    }
    $mysqli->close();
    $mysqli = new mysqli("db", "user", "password", "appDB");
    $result = $mysqli->query('SELECT surveyName, idSurvey, questionBody, idQuestion FROM survey_questions');
    //$result->bind_param('s', $id);
    //$result->execute();
    $flag = false;
    $idQuestion = 0;
    foreach ($result as $row) {
        //var_dump($row);
        if ($row['idSurvey'] == $id) {
            if (!$flag) {
                echo "<h1>{$row['surveyName']}</h1>";
                $flag = true;
            }
            echo "<form class='question' method='post'>";
            echo "<p>{$row['questionBody']}</p>";
            echo "<div>";
            $idQuestion = $row['idQuestion'];
            echo "<label><input type='radio' name=$idQuestion value='1'>Очень плохо</label>";
            echo "<label><input type='radio' name=$idQuestion value='2'>Плохо</label>";
            echo "<label><input type='radio' name=$idQuestion value='3'>Удовлетворительно</label>";
            echo "<label><input type='radio' name=$idQuestion value='4'>Хорошо</label>";
            echo "<label><input type='radio' name=$idQuestion value='5'>Отлично</label>";
            echo "</div>";
        }
    }
    $mysqli->close();
    echo "<input type='submit' name='send' value='Отправить' method='POST'>";
    echo "</form>";
    if (isset($_POST['send'])) {
        foreach ($result as $row) {
            if ($row['idSurvey'] == $id) {
                if (empty($_POST[$row['idQuestion']])) {
                    echo '<script>alert("Пожалуйста, ответьте на все вопросы")</script>';
                    return;
                } else {
                    //echo $_POST[$row['idQuestion']];
                    $mysqli = new mysqli("db", "user", "password", "appDB");
                    $mysqli->set_charset("utf-8");
                    $qID = $row['idQuestion'];
                    if ($_POST[$row['idQuestion']] == 1)
                        $result = $mysqli->query("UPDATE survey_answers SET answer1=answer1+1 WHERE idQuestion=$qID");
                    if ($_POST[$row['idQuestion']] == 2)
                        $result = $mysqli->query("UPDATE survey_answers SET answer2=answer2+1 WHERE idQuestion=$qID");
                    if ($_POST[$row['idQuestion']] == 3)
                        $result = $mysqli->query("UPDATE survey_answers SET answer3=answer3+1 WHERE idQuestion=$qID");
                    if ($_POST[$row['idQuestion']] == 4)
                        $result = $mysqli->query("UPDATE survey_answers SET answer4=answer4+1 WHERE idQuestion=$qID");
                    if ($_POST[$row['idQuestion']] == 5)
                        $result = $mysqli->query("UPDATE survey_answers SET answer5=answer5+1 WHERE idQuestion=$qID");
                    $setstatus = $mysqli->prepare("INSERT INTO completed_surveys(username, idSurvey, surveyName) VALUES (?,?,?)");
                    $setstatus->bind_param('sis', $_SESSION['name'], $row['idSurvey'], $row['surveyName']);
                    $setstatus->execute();
                    $mysqli->close();
                }
            }
        }
        echo "<script> location.href='main.php'; </script>";
    }

}
function addSurvey() {
    if(isset($_POST["make-survey-btn"])) {
        if($_POST['surveyName']) {
            $questions = [];
            for ($i = 0; $i < 100; $i++ ) {
                if ($_POST[(string)$i]) {
                    //echo $_POST[(string)$i] . "<br>";
                    array_push($questions, $_POST[(string)$i]);
                }
            }
            if($questions[0]) {
                $mysqli = new mysqli("db", "user", "password", "appDB");
                $lastId = $mysqli->query("SELECT idSurvey FROM survey_questions ORDER BY idSurvey DESC LIMIT 1");
                foreach($lastId as $row) {
                    //var_dump($row);
                    $id = (int)$row['idSurvey'] + 1;
                    //echo $id;
                }
                foreach ($questions as $question) {
                    echo $question;
                    $stmt = $mysqli->prepare("INSERT INTO survey_questions(surveyName, idSurvey, questionBody, creator) VALUES (?, ?, ?, ?)");
                    $stmt->bind_param('siss', $_POST['surveyName'], $id, $question, $_SESSION['name']);
                    $stmt->execute();
                    $stmt = $mysqli->query("INSERT INTO survey_answers(idSurvey, idQuestion) VALUES ($id, (SELECT idQuestion FROM survey_questions ORDER BY idQuestion DESC LIMIT 1));");
                }
                $mysqli->close();
            }
        }
        else {
            echo "<script>alert('Введите название опроса')</script>";
        }
    }
}
?>