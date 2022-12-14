<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <header class="flex justify-center bg-indigo-900">
        <div class="flex justify-between py-3 text-white" style="width: 1000px;">
            <p><a href="/task/create"><i class="fa-solid fa-house mr-1"></i>Home</a></p>
            <div class="flex justify-center space-x-5">
                <p><a href="/user/update"><i class="fa-solid fa-user mr-1"></i><?=$h($authorizedUser->nickname)?></a></p>
                <p><a href="/logout"><i class="fa-solid fa-right-from-bracket mr-1"></i>Logout</a></p>
            </div>
        </div>
    </header>
    <section class="flex justify-center p-20">
        <div class="items-center p-24 bg-white rounded-3xl" style="width: 1000px;">
            <h1 class="text-4xl font-bold mb-10 text-center text-indigo-500"><i class="fa-solid fa-calendar-check mr-3"></i>To Do</h1>
            <form method="post" action="/task/update?taskId=<?=$task->id?>" class="w-full">
                <?php if(!empty($errors)):?>
                <ul class="mb-5">
                    <?php foreach($errors as $error): ?>
                    <li class="text-center text-red-600"><?=$error[0]?></li>
                    <?php endforeach;?>
                </ul>
                <?php endif;?>
                <div class="space-y-5 items-center mb-10 w-full">
                    <div class="flex space-x-2">
                        <p class="flex items-center border border-gray-200 rounded-lg px-5">
                            <input type="hidden" name="task[isDone]" value="0">
                            <input type="checkbox" name="task[isDone]" value="1" <?=$task->isDone ? "checked" : ""?> id="is-done" class="w-4 h-4 dark:border-gray-600">
                            <label for="is-done" class="ml-2">Done</label>
                        </p>
                        <p><input type="date" name="task[expiredOn]" value="<?=$h($task->expiredOn)?>" class="border border-gray-200 rounded-lg p-2"></p>
                    </div>
                    <p><input type="text" name="task[description]" value="<?=$h($task->description)?>" class="w-full border border-gray-200 rounded-lg p-2"></p>
                </div>
                <div class="flex justify-center space-x-5">
                    <input type="hidden" name="task[id]" value="<?=$task->id?>">
                    <button type="submit" class="w-full py-4 bg-indigo-500 rounded-full">
                        <p class="text-center text-white">Edit</p>
                    </button>
                </div>
                <input type="hidden" name="token" value="<?=$token?>">
            </form>
            <div class="flex justify-between mt-5">
                <p><a href="/task/create"><i class="fa-solid fa-circle-left mr-1"></i>Back</a></p>
                <form method="post" action="/task/delete" class="text-right" onSubmit="return window.confirm('Are you sure you want to delete this item?') ? true : false;">
                    <input type="hidden" name="taskId" value="<?=$task->id?>">
                    <button type="submit" class="hover:text-red-600"><i class="fa-solid fa-trash-can mr-1"></i>Delete</button>
                    <input type="hidden" name="token" value="<?=$token?>">
                </form>
            </div>
        </div>
    </section>
</body>
</html>