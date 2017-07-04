<textarea class="code form-control" name="{{ $key }}" rows="4"><?php
if (is_array($data)) {
    end($data);
    $lastKey = key($data);
    foreach ($data as $key => $id) {
        if ($key == $lastKey)
        echo $id;
        else
        echo $id."\n";
    }
}
else {
    echo $data;
}
?></textarea>
