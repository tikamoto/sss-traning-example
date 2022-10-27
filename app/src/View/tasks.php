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
            <form method="post" action="/task/create" class="w-full">
                <?php if(!empty($errors)):?>
                <ul class="mb-5">
                    <?php foreach($errors as $error): ?>
                    <li class="text-center text-red-600"><?=$error[0]?></li>
                    <?php endforeach;?>
                </ul>
                <?php endif;?>
                <div class="flex justify-center mb-10 space-x-2">
                    <p><input type="date" name="task[expiredOn]" value="<?=$h($task->expiredOn)?>" class="border border-gray-200 p-4 rounded-lg"></p>
                    <p class="w-full"><input type="text" name="task[description]" value="<?=$h($task->description)?>" class="w-full border border-gray-200 p-4 rounded-lg" placeholder="What will you do?"></p>
                    <button type="submit" class="px-8 bg-indigo-500 rounded-lg">
                        <p class="text-center text-white">Add</p>
                    </button>
                </div>
                <input type="hidden" name="token" value="<?=$token?>">
            </form>
            <ul class="space-y-5">
                <?php foreach($tasks as $task):?>
                <li>
                    <form method="post" action="/task/complete" class="flex justify-center shadow-md py-4 px-5 rounded-full border border-gray-100 space-x-2">

                        <?php if($task->isDone()):?>
                            <span class="border-r border-gray-300 pr-2"><button type="submit"><i class="fa-solid fa-circle-check text-gray-300 text-xl"></i></button></span>
                            <span class="bg-gray-300 rounded-lg text-white px-3 whitespace-nowrap"><?=$h($task->getExpiredOn())?></span>
                            <span class="w-full truncate line-through text-gray-300"><?=$h($task->description)?></span>
                            <input type="hidden" name="undone" value="1">
                        <?php else:?>
                            <span class="border-r border-gray-300 pr-2"><button type="submit"><i class="fa-regular fa-circle-check text-green-500 text-xl"></i></button></span>
                            <span class="<?php echo $task->isExpired() ? "bg-red-300" : "bg-blue-300"?> rounded-lg text-white px-3 whitespace-nowrap"><?=$h($task->getExpiredOn())?></span>
                            <span class="w-full truncate"><?=$h($task->description)?></span>
                            <input type="hidden" name="done" value="1">
                        <?php endif;?>

                        <span><a href="/task/update?taskId=<?=$h($task->id)?>"><i class="fa-solid fa-pen-to-square text-indigo-500 text-xl"></i></a></span>
                        <input type="hidden" name="taskId" value="<?=$h($task->id)?>">
                        <input type="hidden" name="token" value="<?=$token?>">
                    </form>
                </li>  
                <?php endforeach;?>
            </ul>
        </div>
    </section>
</body>
</html>