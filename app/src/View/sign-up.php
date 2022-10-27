<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    
    <section class="flex justify-center p-20">
        <div class="items-center p-24 bg-white rounded-3xl" style="width: 600px;">
            <h1 class="text-4xl font-bold mb-10 text-center text-indigo-500"><i class="fa-solid fa-user-plus mr-3"></i>Sign Up</h1>
            <form method="post" action="/user/create" class="w-full">
                <div class="space-y-5 items-center mb-10 w-full">
                    <?php if(!empty($errors)):?>
                    <ul>
                        <?php foreach($errors as $error): ?>
                        <li class="text-center text-red-600"><?=$error[0]?></li>
                        <?php endforeach;?>
                    </ul>
                    <?php endif;?>
                    <p><input type="text" name="user[nickname]" value="<?=$h($user->nickname)?>" class="w-full border border-gray-200 rounded-lg p-2" placeholder="Nickname"></p>
                    <p><input type="text" name="user[email]" value="<?=$h($user->email)?>" class="w-full border border-gray-200 rounded-lg p-2" placeholder="Email"></p>
                    <p><input type="text" name="user[password]" value="<?=$h($user->password)?>" class="w-full border border-gray-200 rounded-lg p-2" placeholder="Password"></p>
                </div>
                <button type="submit" class="w-full py-4 bg-indigo-500 rounded-full mb-5">
                    <p class="text-center text-white">Sign Up</p>
                </button>
                <p class="text-center">All ready have an account?
                    <a class="ml-2 underline underline-offset-4 hover:no-underline" href="/login">Login</a></p>
                <input type="hidden" name="token" value="<?=$token?>">
            </form>
        </div>
    </section>
</body>
</html>