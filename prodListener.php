<?php










    $file = scandir("./directoryToBuild", 1);
    exec('tar -xzf ' .$file[0]. ' --directory ./directoryToSend');



