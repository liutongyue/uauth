<?php

namespace UAuth\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public static function getUserInfoByUName(AppInfo $app, $username)
    {
        self::initDBConn($app);

        $where = [];
        foreach ($app->db->user_table_usernames as $uname) {
            $where[] = $uname . ' = ?';
        }
        $where_sql = implode($where, ' or ');
        $sql = "select * from {$app->db->user_table} where " . $where_sql;

        $result = DB::connection('temp')->selectOne($sql, array_fill(0, count($app->db->user_table_usernames), $username));

        return $result;
    }


    public static function getUserInfoByUId(AppInfo $app, $uid)
    {
        self::initDBConn($app);

        $sql = "select * from {$app->db->user_table} where id = ?";

        $result = DB::connection('temp')->selectOne($sql, [$uid]);

        return $result;
    }


    private static function initDBConn(AppInfo $app)
    {

        $db = $app->db;
        $db_config = $db->convertToDB();

        Config::set('database.connections.temp', $db_config);
    }

}
