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
            <h1 class="text-4xl font-bold mb-10 text-center text-indigo-500"><i class="fa-solid fa-user mr-3"></i>Account</h1>
            <form method="post" action="/user/update" class="w-full">
                <?php if(!empty($errors)):?>
                <ul class="mb-5">
                    <?php foreach($errors as $error): ?>
                    <li class="text-center text-red-600"><?=$error[0]?></li>
                    <?php endforeach;?>
                </ul>
                <?php endif;?>
                <div class="space-y-5 items-center mb-10 w-full">
                    <dl>
                        <dt class="font-bold">Nickname:</span>
                        <dd><input type="text" name="user[nickname]" value="<?=$h($user->nickname)?>" class="w-full border border-gray-200 rounded-lg p-2"></dd>
                    </dl>
                    <dl>
                        <dt class="font-bold">Email:</dt>
                        <dd><input type="text" name="user[email]" value="<?=$h($user->email)?>" class="w-full border border-gray-200 rounded-lg p-2"></dd>
                    </dl>
                    <dl>
                        <dt class="font-bold">New Password:</dt>
                        <dd>
                            <input type="text" name="user[password]" value="<?=$h($user->hasRawPassword() ? $user->password : "")?>" class="w-full border border-gray-200 rounded-lg p-2">
                            <span class="text-gray-400">To change the current password, enter the new password in field.</span>
                        </dd>
                    </dl>
                </div>
                <div class="flex justify-center space-x-5">
                    <button type="submit" class="w-full py-4 bg-indigo-500 rounded-full">
                        <p class="text-center text-white">Edit</p>
                    </button>
                </div>
                <input type="hidden" name="token" value="<?=$token?>">
            </form>
            <div class="flex justify-between mt-5">
                <p><a href="/task/create"><i class="fa-solid fa-circle-left mr-1"></i>Back</a></p>
                <form method="post" action="/user/delete" class="text-right" onSubmit="return window.confirm('Are you sure you want to delete account?') ? true : false;">
                    <button type="submit" class="hover:text-red-600"><i class="fa-solid fa-trash-can mr-1"></i>Delete My Account</button>
                    <input type="hidden" name="token" value="<?=$token?>">
                </form>
            </div>
        </div>
    </section>
</body>
</html>