<input type="hidden" name="{{ $key }}" value="0">
<input class="form-control" type="checkbox" id="{{ $key }}" value="1" name="{{ $key }}" {{ !$data && isset($data) ? "" : "checked"}} >
