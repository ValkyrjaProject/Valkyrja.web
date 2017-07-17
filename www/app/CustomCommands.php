<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CustomCommands extends Model
{
    const COMMANDS_LIST = '../../config/commandsList.json';
    const COMMAND_KEYS = [
        'ID',
        'Response',
        'Description',
        'RoleWhitelist',
        'DeleteRequest'
    ];
    private $commandsList;

    /**
     * CustomCommands constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct();
        $this->commandsList = $this->getBotwinderCommands($request);
    }


    /**
     * @param Collection $inputs
     * @return array
     */
    public function validate(Collection $inputs)
    {
        $inputs = $inputs->unique('ID');
        $inputs = $inputs->all();
        foreach ($inputs as $key => &$input) {
            $input['ID'] = $this->validateId($input['ID']);
            $input['RoleWhitelist'] = $this->validateRoles($input);
            $input['Description'] = trim($input['Description'].' (Custom non-Botwinder command.)');

            if ($input['ID'] === false || strlen($input['Response']) === 0) {
                array_forget($inputs, $key);
            }

            if (!isset($input['DeleteRequest'])) $input['DeleteRequest'] = false;
            $input['DeleteRequest'] = $input['DeleteRequest'] == 'false' ? false : true;
            $input = collect($input)->only(self::COMMAND_KEYS)->all();
        }
        return $inputs;
    }

    /**
     * @param $id
     * @return String
     * @internal param $input
     */
    public function validateId($id)
    {
        if (
            isset($id)
            && strlen($id) > 0
            && !array_has($this->commandsList, $id)
        ) {
            return (String)preg_replace('/[^a-zA-Z0-9]/', '', $id);
        }
        return false;
    }

    /**
     * @param Request $request
     * @return array|string
     */
    public static function getBotwinderCommands(Request $request)
    {
        $file = file_get_contents(self::COMMANDS_LIST);
        if (!$request->wantsJson()) $file = json_decode($file);
        return $file;
    }

    /**
     * @param $input
     * @return array
     */
    public function validateRoles($input)
    {
        if (!isset($input['RoleWhitelist']) || !is_array($input['RoleWhitelist'])) {
            $input['RoleWhitelist'] = null;
        } else {
            foreach ($input['RoleWhitelist'] as $roleKey => &$role) {
                $input['RoleWhitelist'][$roleKey] = (int)$role;
            }
        }
        return $input['RoleWhitelist'];
    }
}
