<?php

$filename = 'tasks.json';
//$tasks = file_get_contents(__DIR__ . '/tasks.json');

function get_tasks()
{
    global $filename;
    $data = file_get_contents($filename);
    return json_decode($data, true);
}

function add_task($task)
{
    global $filename;
    $tasks = get_tasks();
    $task['id'] = count($tasks) + 1;
    array_push($tasks, $task);
    file_put_contents($filename, json_encode($tasks));
    return $task;
}

function update_task($id, $task)
{
    global $filename;
    $tasks = get_tasks();
    foreach ($tasks as $key => $value) {
        if ($value['id'] == $id) {
            $tasks[$key]['text'] = $task['text'];
            $tasks[$key]['done'] = $task['done'];
            file_put_contents($filename, json_encode($tasks));
            return $tasks[$key];
        }
    }
    return null;
}

function delete_task($id)
{
    global $filename;
    $tasks = get_tasks();
    foreach ($tasks as $key => $value) {
        if ($value['id'] == $id) {
            unset($tasks[$key]);
            file_put_contents($filename, json_encode(array_values($tasks)));
            return true;
        }
    }
    return false;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo json_encode(get_tasks());
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task = json_decode(file_get_contents('php://input'), true);
    echo json_encode(add_task($task));
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents('php://input'), $put_data);
    $id = $put_data['id'];
    $task = json_decode($put_data['task'], true);
    echo json_encode(update_task($id, $task));
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents('php://input'), $delete_data);
    $id = $delete_data['id'];
    echo json_encode(delete_task($id));
}

echo $tasks;
