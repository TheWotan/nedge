<?php

namespace app\commands;

use app\models\Country;
use app\models\Number;
use app\models\SendLog;
use app\models\User;
use Faker\Factory;
use Faker\Generator;
use Yii;
use yii\console\Controller;

class GeneratorController extends Controller
{

    /** @var Generator */
    protected $faker;

    public $countriesAmount     = 10;
    public $usersAmount         = 10;
    public $numbersAmount       = 1000;
    public $logsAmount          = 1000000;

    public function options($actionID)
    {
        return [
            'usersAmount',
            'countriesAmount',
            'numbersAmount',
            'logsAmount',
        ];
    }

    public function optionAliases()
    {
        return [
            'ua' => 'usersAmount',
            'ca' => 'countriesAmount',
            'na' => 'numbersAmount',
            'la' => 'logsAmount'
        ];
    }

    /**
     * Generate fake data
     */
    public function actionFaker()
    {
        $this->faker = Factory::create();

        $this->generateFakeUsers($this->usersAmount);

        $this->generateFakeCountries($this->countriesAmount);

        $this->generateFakeNumbers($this->numbersAmount);

        $this->generateFakeLog($this->logsAmount);

    }

    /**
     * Generate fake users
     * @param $amount
     */
    private function generateFakeUsers($amount)
    {
        $generated = 0;
        for ($i = 0; $i < $amount; $i++) {
            $user = new User();
            $user->usr_name = $this->faker->name;
            $user->usr_active = ($this->faker->numberBetween(0, 100) > 3 ? 1 : 0); // 3% not active users


            try {
                if ($user->validate()) {
                    if ($user->save()) {
                        $generated++;
                    }
                }
            } catch (\Exception $exception) {
                echo $exception->getMessage() . PHP_EOL;
            }
        }

        $this->stdout("successfully generate " . $generated . " users" . PHP_EOL);

    }

    /**
     * Generate fake countries
     * @param $amount
     */
    private function generateFakeCountries($amount)
    {
        $generated = 0;

        for ($i = 0; $i < $amount; $i++) {
            $country = new Country();
            $country->cnt_code = $this->faker->countryCode;
            $country->cnt_title = $this->faker->country;

            try {
                if ($country->validate()) {
                    if ($country->save()) {
                        $generated++;
                    }                }
            } catch (\Exception $exception) {
                echo $exception->getMessage() . PHP_EOL;
            }
        }

        $this->stdout("successfully generate " . $generated . " countries" . PHP_EOL);

    }

    /**
     * Generate fake numbers
     * @param $amount
     */
    private function generateFakeNumbers($amount)
    {
        $generated = 0;

        $countryIDs = Country::find()
            ->select('cnt_id')
            ->column();
        for ($i = 0; $i < $amount; $i++) {
            $number = new Number();
            $number->num_number = $this->faker->phoneNumber;
            $number->cnt_id = $countryIDs[array_rand($countryIDs, 1)];

            try {
                if ($number->validate()) {
                    if ($number->save()) {
                        $generated++;
                    }                }
            } catch (\Exception $exception) {
                echo $exception->getMessage() . PHP_EOL;
            }
        }

        $this->stdout("successfully generate " . $generated . " numbers" . PHP_EOL);

    }

    /**
     * Generate fake sent log
     * @param $amount
     */
    private function generateFakeLog($amount)
    {
        ini_set('max_execution_time', 5*60);
        ini_set('memory_limit', '512M');

        $generated = 0;

        $userIDs = User::find()
            ->select('usr_id')
            ->column();

        $numberIDs = Number::find()
            ->select('num_id')
            ->column();

        $batch = 10000;

        for ($j=0; $j < $amount/$batch; $j++) {

            $sentLogs = [];
            for ($i = 0; $i < $batch; $i++) {

                $sentLogs[] = [
                    'usr_id' => $userIDs[array_rand($userIDs, 1)],
                    'num_id' => $numberIDs[array_rand($numberIDs, 1)],
                    'log_message' => $this->faker->text(32),
                    'log_success' => ($this->faker->numberBetween(0, 100) > 5 ? 1 : 0), // 5% not success messages
                    'log_created' => $this->faker->dateTimeBetween('-3 months', 'now')->format('Y-m-d H:i:s')
                ];
            }

            try {
                $generated += Yii::$app->db->createCommand()->batchInsert(SendLog::tableName(), ['usr_id', 'num_id', 'log_message', 'log_success', 'log_created'], $sentLogs)->execute();
            } catch (\Exception $exception) {
                echo $exception->getMessage() . PHP_EOL;
            }
        }

        $this->stdout("successfully generate " . $generated . " logs" . PHP_EOL);
    }
}
