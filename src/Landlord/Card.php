<?php
namespace Willow\Landlord;


class Card
{
    /**
     * @var array
     */
    private $config = [
        'list'=>[
            'M0',
            'M1',
            'S2',
            'H2',
            'W2',
            'D2',
            'SA',
            'HA',
            'WA',
            'DA',
            'SK',
            'HK',
            'WK',
            'DK',
            'SQ',
            'HQ',
            'WQ',
            'DQ',
            'SJ',
            'HJ',
            'WJ',
            'DJ',
            'S10',
            'H10',
            'W10',
            'D10',
            'S9',
            'H9',
            'W9',
            'D9',
            'S8',
            'H8',
            'W8',
            'D8',
            'S7',
            'H7',
            'W7',
            'D7',
            'S6',
            'H6',
            'W6',
            'D6',
            'S5',
            'H5',
            'W5',
            'D5',
            'S4',
            'H4',
            'W4',
            'D4',
            'S3',
            'H3',
            'W3',
            'D3',
        ],
        'point'=>[
            'M0'=>54,
            'M1'=>53,
            'S2'=>52,
            'H2'=>51,
            'W2'=>50,
            'D2'=>49,
            'SA'=>48,
            'HA'=>47,
            'WA'=>46,
            'DA'=>45,
            'SK'=>44,
            'HK'=>43,
            'WK'=>42,
            'DK'=>41,
            'SQ'=>40,
            'HQ'=>39,
            'WQ'=>38,
            'DQ'=>37,
            'SJ'=>36,
            'HJ'=>35,
            'WJ'=>34,
            'DJ'=>33,
            'S10'=>32,
            'H10'=>31,
            'W10'=>30,
            'D10'=>29,
            'S9'=>28,
            'H9'=>27,
            'W9'=>26,
            'D9'=>25,
            'S8'=>24,
            'H8'=>23,
            'W8'=>22,
            'D8'=>21,
            'S7'=>20,
            'H7'=>19,
            'W7'=>18,
            'D7'=>17,
            'S6'=>16,
            'H6'=>15,
            'W6'=>14,
            'D6'=>13,
            'S5'=>12,
            'H5'=>11,
            'W5'=>10,
            'D5'=>9,
            'S4'=>8,
            'H4'=>7,
            'W4'=>6,
            'D4'=>5,
            'S3'=>4,
            'H3'=>3,
            'W3'=>2,
            'D3'=>1,
        ],
        'value'=> [
            '3'=>1,
            '4'=>2,
            '5'=>3,
            '6'=>4,
            '7'=>5,
            '8'=>6,
            '9'=>7,
            '10'=>8,
            'J'=>9,
            'Q'=>10,
            'K'=>11,
            'A'=>12,
            '2'=>13,
            '1'=>14,
            '0'=>15,
        ]
    ];

    const single        = 1;
    const pair          = 2;
    const three         = 3;
    const threeSingle   = 4;
    const threePair     = 5;
    const bomb          = 6;
    const bombTwoSingle = 7;
    const bombTwoPair   = 8;
    const straight      = 9;
    const company       = 10;
    const plane         = 11;
    const planeSingle   = 12;
    const planePair     = 13;
    const kingBomb      = 14;

    public function __construct(array $config = [])
    {
        if (!empty($config)) $this->config = $config;
    }

    /**
     * 是否单牌
     * @param array $cards
     * @return array
     */
    public function isSingle(array $cards) :array
    {
        return [
            'check'=>count($cards) === 1,
            'data'=>[
                'type' => self::single,
                'length' => count($cards),
                'value' => $this->config['value'][substr($cards[0],1)
                ]
            ]
        ];
    }

    /**
     * 是否对子
     * @param array $cards
     * @return array
     */
    public function isPair(array $cards) :array
    {
        return [
            'check'=>count($cards) === 2 && substr($cards[0],1) === substr($cards[1],1),
            'data'=>[
                'type' => self::pair,
                'length' => count($cards),
                'value' => $this->config['value'][substr($cards[0],1)
                ]
            ]
        ];
    }

    /**
     * 是否三张
     * @param array $cards
     * @return array
     */
    public function isThree(array $cards) :array
    {
        return [
            'check'=> count($cards) === 3 && substr($cards[0],1) === substr($cards[1],1) && substr($cards[0],1) === substr($cards[2],1),
            'data'=>[
                'type' => self::three,
                'length' => count($cards),
                'value' => $this->config['value'][substr($cards[0],1)
                ]
            ]
        ];
    }

    /**
     * 是否三带一
     * @param array $cards
     * @return array
     */
    public function isThreeSingle(array $cards) :array
    {
        if (count($cards) != 4) return ['check'=>false,'data'=>[]];
        $substr = [];
        foreach ($cards as $card){
            $substr[] = substr($card,1);
        }
        $cardTimes = array_count_values($substr);
        if (count($cardTimes) != 2) return ['check'=>false,'data'=>[]];
        $value = 0;
        foreach ($cardTimes as $k => $v){
            if ($v != 3) continue;
            $value = $k;
            break;
        }
        return [
            'check'=> array_values($cardTimes) == [1,3] || array_values($cardTimes) == [3,1],
            'data'=>[
                'type' => self::threeSingle,
                'length' => count($cards),
                'value' => $this->config['value'][$value]
            ]
        ];
    }

    /**
     * 是否三带二
     * @param array $cards
     * @return array
     */
    public function isThreePair(array $cards) :array
    {
        if (count($cards) != 5) return ['check'=>false,'data'=>[]];
        $substr = [];
        foreach ($cards as $card){
            $substr[] = substr($card,1);
        }
        $cardTimes = array_count_values($substr);
        if (count($cardTimes) != 2) return ['check'=>false,'data'=>[]];
        $value = 0;
        foreach ($cardTimes as $k => $v){
            if ($v != 3) continue;
            $value = $k;
            break;
        }
        return [
            'check'=> array_values($cardTimes) == [2,3] || array_values($cardTimes) == [3,2],
            'data'=>[
                'type' => self::threePair,
                'length' => count($cards),
                'value' => $this->config['value'][$value]
            ]
        ];
    }

    /**
     * 是否顺子   不能包含2大小王
     * @param array $cards
     * @return array
     */
    public function isStraight(array $cards) :array
    {
        if (count($cards) < 5) return ['check'=>false,'data'=>[]];
        $substr = [];
        foreach ($cards as $card){
            $substr[] = $this->config['value'][substr($card,1)];
        }
        $cardTimes = array_values(array_count_values($substr));
        if (max($cardTimes) > 1) return ['check'=>false,'data'=>[]];
        rsort($substr);
        $bool = true;
        foreach ($substr as $k => $v){
            if (in_array($v,[13,14,15])){
                $bool = false;
                break;
            }
            if (isset($substr[$k+1])) {
                if ($v - $substr[$k + 1] > 1){
                    $bool = false;
                    break;
                }
            }
        }
        return [
            'check'=> $bool,
            'data'=>[
                'type' => self::straight,
                'length' => count($cards),
                'value' => $substr[0]
            ]
        ];
    }

    /**
     * 是否连对
     * @param array $cards
     * @return array
     */
    public function isCompany(array $cards) :array
    {
        if (count($cards) < 6) return ['check'=>false,'data'=>[]];
        $substr = [];
        foreach ($cards as $card){
            $substr[] = $this->config['value'][substr($card,1)];
        }
        $cardTimes = array_values(array_count_values($substr));
        if (max($cardTimes) > 2 || min($cardTimes) < 2) return ['check'=>false,'data'=>[]];
        $unique = array_unique($substr);
        rsort($unique);
        $bool = true;
        foreach ($unique as $k => $v){
            if (in_array($v,[13,14,15])){
                $bool = false;
                break;
            }
            if (isset($unique[$k+1])) {
                if ($v - $unique[$k + 1] > 1){
                    $bool = false;
                    break;
                }
            }

        }
        return [
            'check'=> $bool,
            'data'=>[
                'type' => self::company,
                'length' => count($cards),
                'value' => $unique[0]
            ]
        ];
    }

    /**
     * 是否飞机
     * @param array $cards
     * @return array
     */
    public function isPlane(array $cards) :array
    {
        if (count($cards) < 6) return ['check'=>false,'data'=>[]];
        $substr = [];
        foreach ($cards as $card){
            $substr[] = $this->config['value'][substr($card,1)];
        }
        $cardTimes = array_values(array_count_values($substr));
        if (max($cardTimes) > 3 || min($cardTimes) < 3) return ['check'=>false,'data'=>[]];
        $unique = array_unique($substr);
        rsort($unique);
        $bool = true;
        foreach ($unique as $k => $v){
            if (in_array($v,[13,14,15])){
                $bool = false;
                break;
            }
            if (isset($unique[$k+1])) {
                if ($v - $unique[$k + 1] > 1){
                    $bool = false;
                    break;
                }
            }
        }
        return [
            'check'=> $bool,
            'data'=>[
                'type' => self::plane,
                'length' => count($cards),
                'value' => $unique[0]
            ]
        ];
    }

    /**
     * 飞机带单
     * @param array $cards
     * @return array
     */
    public function isPlaneSingle(array $cards) :array
    {
        if (count($cards) < 8 || count($cards) % 4) return ['check'=>false,'data'=>[]];
        $substr = [];
        foreach ($cards as $card){
            $substr[] = $this->config['value'][substr($card,1)];
        }
        $cardTimes = array_count_values($substr);
        if (max($cardTimes) > 3) return ['check'=>false,'data'=>[]];

        $waitCheck = [];
        foreach ($cardTimes as $cardValue => $times){
            if ($times != 3) continue;
            $waitCheck[] = $cardValue;
        }
        rsort($waitCheck);
        $bool = true;
        foreach ($waitCheck as $k => $v){
            if (in_array($v,[13,14,15])){
                $bool = false;
                break;
            }
            if (isset($waitCheck[$k+1])) {
                if ($v - $waitCheck[$k + 1] > 1){
                    $bool = false;
                    break;
                }
            }
        }
        return [
            'check'=> $bool,
            'data'=>[
                'type' => self::planeSingle,
                'length' => count($cards),
                'value' => $waitCheck[0]
            ]
        ];
    }

    /**
     * 飞机带对
     * @param array $cards
     * @return array
     */
    public function isPlanePair(array $cards) :array
    {
        if (count($cards) < 10 || count($cards) % 5) return ['check'=>false,'data'=>[]];
        $substr = [];
        foreach ($cards as $card){
            $substr[] = $this->config['value'][substr($card,1)];
        }
        $cardTimes = array_count_values($substr);
        if (max($cardTimes) > 3 || min($cardTimes) < 2) return ['check'=>false,'data'=>[]];

        $waitCheck = [];
        foreach ($cardTimes as $cardValue => $times){
            if ($times != 3) continue;
            $waitCheck[] = $cardValue;
        }
        rsort($waitCheck);
        $bool = true;
        foreach ($waitCheck as $k => $v){
            if (in_array($v,[13,14,15])){
                $bool = false;
                break;
            }
            if (isset($waitCheck[$k+1])) {
                if ($v - $waitCheck[$k + 1] > 1){
                    $bool = false;
                    break;
                }
            }
        }
        return [
            'check'=> $bool,
            'data'=>[
                'type' => self::planePair,
                'length' => count($cards),
                'value' => $waitCheck[0]
            ]
        ];
    }

    /**
     * 是否炸弹
     * @param array $cards
     * @return array
     */
    public function isBomb(array $cards) :array
    {
        return [
            'check'=> count($cards) === 4 && substr($cards[0],1) === substr($cards[1],1) && substr($cards[0],1) === substr($cards[2],1) && substr($cards[0],1) === substr($cards[3],1),
            'data'=>[
                'type' => self::bomb,
                'length' => count($cards),
                'value' => $this->config['value'][substr($cards[0],1)]
            ]
        ];
    }

    /**
     * 四带二单
     * @param array $cards
     * @return array
     */
    public function isBombTwoSingle(array $cards) :array
    {
        if (count($cards) != 6) return ['check'=>false,'data'=>[]];
        $substr = [];
        foreach ($cards as $card){
            $substr[] = $this->config['value'][substr($card,1)];
        }
        $cardTimes = array_count_values($substr);
        $cardValue = 0;
        foreach ($cardTimes as $value => $times){
            if ($times != 4) continue;
            $cardValue = $value;
            break;
        }
        rsort($cardTimes);

        return [
            'check'=> $cardTimes == [4,1,1],
            'data'=>[
                'type' => self::bombTwoSingle,
                'length' => count($cards),
                'value' => $cardValue
            ]
        ];
    }

    /**
     * 四带两对
     * @param array $cards
     * @return array
     */
    public function isBombTwoPair(array $cards) :array
    {
        if (count($cards) != 8) return ['check'=>false,'data'=>[]];
        $substr = [];
        foreach ($cards as $card){
            $substr[] = $this->config['value'][substr($card,1)];
        }
        $cardTimes = array_count_values($substr);
        $cardValue = 0;
        foreach ($cardTimes as $value => $times){
            if ($times != 4) continue;
            $cardValue = $value;
            break;
        }
        rsort($cardTimes);

        return [
            'check'=> $cardTimes == [4,2,2],
            'data'=>[
                'type' => self::bombTwoPair,
                'length' => count($cards),
                'value' => $cardValue
            ]
        ];
    }

    /**
     * 是否王炸
     * @param array $cards
     * @return array
     */
    public function isKingBomb(array $cards) :array
    {
        return [
            'check'=> count($cards) === 2 && ($cards == ['M0','M1'] || $cards == ['M1','M0']),
            'data'=>[
                'type' => self::kingBomb,
                'length' => count($cards),
                'value' => 15
            ]
        ];
    }

    /**
     * 确定牌型
     * @param array $cards
     * @return array
     */
    public function cardType(array $cards) :array
    {
        $res = [];
        $cardNum = count($cards);
        switch ($cardNum){
            case 1:
                $check = $this->isSingle($cards);
                if ($check['check']) $res = $check['data'];
                break;
            case 2:
                $check = $this->isPair($cards);
                if ($check['check']) $res = $check['data'];
                $check = $this->isKingBomb($cards);
                if ($check['check']) $res = $check['data'];
                break;
            case 3:
                $check = $this->isThree($cards);
                if ($check['check']) $res = $check['data'];
                break;
            case 4:
                $check = $this->isThreeSingle($cards);
                if ($check['check']) $res = $check['data'];
                $check = $this->isBomb($cards);
                if ($check['check']) $res = $check['data'];
                break;
            case 5:
                $check = $this->isThreePair($cards);
                if ($check['check']) $res = $check['data'];
                $check = $this->isStraight($cards);
                if ($check['check']) $res = $check['data'];
                break;
            case 6:
                $check = $this->isStraight($cards);
                if ($check['check']) $res = $check['data'];
                $check = $this->isCompany($cards);
                if ($check['check']) $res = $check['data'];
                $check = $this->isPlane($cards);
                if ($check['check']) $res = $check['data'];
                $check = $this->isBombTwoSingle($cards);
                if ($check['check']) $res = $check['data'];
                break;
            case 7:
            case 11:
            case 13:
            case 17:
            case 19:
                $check = $this->isStraight($cards);
                if ($check['check']) $res = $check['data'];
                break;
            case 8:
                $check = $this->isStraight($cards);
                if ($check['check']) $res = $check['data'];
                $check = $this->isCompany($cards);
                if ($check['check']) $res = $check['data'];
                $check = $this->isPlaneSingle($cards);
                if ($check['check']) $res = $check['data'];
                $check = $this->isBombTwoPair($cards);
                if ($check['check']) $res = $check['data'];
                break;
            case 9:
                $check = $this->isStraight($cards);
                if ($check['check']) $res = $check['data'];
                $check = $this->isPlane($cards);
                if ($check['check']) $res = $check['data'];
                break;
            case 10:
                $check = $this->isStraight($cards);
                if ($check['check']) $res = $check['data'];
                $check = $this->isCompany($cards);
                if ($check['check']) $res = $check['data'];
                $check = $this->isPlanePair($cards);
                if ($check['check']) $res = $check['data'];
                break;
            case 12:
                $check = $this->isStraight($cards);
                if ($check['check']) $res = $check['data'];
                $check = $this->isCompany($cards);
                if ($check['check']) $res = $check['data'];
                $check = $this->isPlaneSingle($cards);
                if ($check['check']) $res = $check['data'];
                $check = $this->isPlane($cards);
                if ($check['check']) $res = $check['data'];
                break;
            case 14:
                $check = $this->isStraight($cards);
                if ($check['check']) $res = $check['data'];
                $check = $this->isCompany($cards);
                if ($check['check']) $res = $check['data'];
                break;
            case 15:
                $check = $this->isStraight($cards);
                if ($check['check']) $res = $check['data'];
                $check = $this->isPlane($cards);
                if ($check['check']) $res = $check['data'];
                $check = $this->isPlanePair($cards);
                if ($check['check']) $res = $check['data'];
                break;
            case 16:
                $check = $this->isStraight($cards);
                if ($check['check']) $res = $check['data'];
                $check = $this->isCompany($cards);
                if ($check['check']) $res = $check['data'];
                $check = $this->isPlaneSingle($cards);
                if ($check['check']) $res = $check['data'];
                break;
            case 18:
                $check = $this->isStraight($cards);
                if ($check['check']) $res = $check['data'];
                $check = $this->isCompany($cards);
                if ($check['check']) $res = $check['data'];
                $check = $this->isPlane($cards);
                if ($check['check']) $res = $check['data'];
                break;
            case 20:
                $check = $this->isStraight($cards);
                if ($check['check']) $res = $check['data'];
                $check = $this->isCompany($cards);
                if ($check['check']) $res = $check['data'];
                $check = $this->isPlaneSingle($cards);
                if ($check['check']) $res = $check['data'];
                $check = $this->isPlanePair($cards);
                if ($check['check']) $res = $check['data'];
                break;
        }
        return $res;
    }

    /**
     * 比较大小
     * @param array $thisCard [type,length,value]
     * @param array $lastCard [type,length,value]
     * @return bool
     */
    public function compare(array $thisCard,array $lastCard) :bool
    {
        if ($thisCard['type'] == self::kingBomb) return true;
        if ($lastCard['type'] == self::kingBomb) return false;
        if (in_array($thisCard['type'],[self::bomb,self::kingBomb]) && !in_array($lastCard['type'],[self::bomb,self::kingBomb])) return true;
        if (!in_array($thisCard['type'],[self::bomb,self::kingBomb]) && in_array($lastCard['type'],[self::bomb,self::kingBomb])) return false;

        if ($thisCard['length'] != $lastCard['length']) return false;
        if ($thisCard['value'] <= $lastCard['value']) return false;
        return true;
    }

    /**
     * 提示出牌 单牌
     * @param array $cards 手牌 ['C6','S8']......
     * @param array $lastCardType 上一手牌信息 [type,length,value]
     * @return array
     */
    public function tipSingle(array $cards,array $lastCardType) :array
    {
        $res = [];
        if ($lastCardType['type'] != self::single) return $res;
        $cardValueTime = [];
        foreach ($cards as $card){
            $cardValue = $this->config['value'][substr($card,1)];
            $cardValueTime[$cardValue][] = $card;
            if ($cardValue <= $lastCardType['value']) continue;
            $res[] = [$card];
        }
        //炸弹
        foreach ($cardValueTime as $value => $card){
            if (count($card) >= 4){
                $res[] = $card;
            }
        }
        //王炸
        if (isset($cardValueTime[14]) && isset($cardValueTime[15])) $res[] = array_merge($cardValueTime[14],$cardValueTime[15]);
        return $res;
    }

    /**
     * 提示出牌 对子
     * @param array $cards
     * @param array $lastCardType 上一手牌信息 [type,length,value]
     * @return array
     */
    public function tipPair(array $cards,array $lastCardType) :array
    {
        $res = [];
        if ($lastCardType['type'] != self::pair) return $res;
        $cardValueTime = [];
        foreach ($cards as $card){
            $cardValue = $this->config['value'][substr($card,1)];
            $cardValueTime[$cardValue][] = $card;
        }

        foreach ($cardValueTime as $value => $card){
            $countCard = count($card);
            if ($countCard < 2) continue;
            //对子 炸弹
            if (($countCard == 2 && $value > $lastCardType['value']) || $countCard == 4) $res[] = $card;
            //三张
            if ($countCard > 2 && $value > $lastCardType['value']) {
                for ($i = 0; $i < $countCard - 1;$i ++){
                    $res[] = array_slice($card,$i,2);
                }
            }
        }
        //王炸
        if (isset($cardValueTime[14]) && isset($cardValueTime[15])) $res[] = array_merge($cardValueTime[14],$cardValueTime[15]);
        return $res;
    }

    /**
     * 提示出牌 三张
     * @param array $cards
     * @param array $lastCardType 上一手牌信息 [type,length,value]
     * @return array
     */
    public function tipThree(array $cards,array $lastCardType) :array
    {
        $res = [];
        if ($lastCardType['type'] != self::three) return $res;
        $cardValueTime = [];
        foreach ($cards as $card){
            $cardValue = $this->config['value'][substr($card,1)];
            $cardValueTime[$cardValue][] = $card;
        }

        foreach ($cardValueTime as $value => $card){
            $countCard = count($card);
            if ($countCard < 3) continue;
            //三张 炸弹
            if (($countCard == 3 && $value > $lastCardType['value']) || $countCard == 4) $res[] = $card;
            //三张
            if ($countCard > 3 && $value > $lastCardType['value']) {
                for ($i = 0; $i < $countCard - 2;$i ++){
                    $res[] = array_slice($card,$i,3);
                }
            }
        }
        //王炸
        if (isset($cardValueTime[14]) && isset($cardValueTime[15])) $res[] = array_merge($cardValueTime[14],$cardValueTime[15]);
        return $res;
    }

    /**
     * 提示出牌 三带一
     * @param array $cards
     * @param array $lastCardType
     * @return array
     */
    public function tipThreeSingle(array $cards,array $lastCardType) :array
    {
        $res = [];
        if ($lastCardType['type'] != self::threeSingle) return $res;
        $cardValueTime = [];
        foreach ($cards as $card){
            $cardValue = $this->config['value'][substr($card,1)];
            $cardValueTime[$cardValue][] = $card;
        }

        foreach ($cardValueTime as $value => $card){
            $countCard = count($card);
            if ($countCard < 3) continue;
            //炸弹
            if ($countCard == 4) $res[] = $card;
            //三张
            if ($countCard >= 3 && $value > $lastCardType['value']) {
                for ($i = 0; $i < $countCard - 2;$i ++){
                    foreach ($cards as $single){
                        if ($this->config['value'][substr($single,1)] != $value){
                            $res[] = array_merge(array_slice($card,$i,3),[$single]);
                        }
                    }
                }
            }
        }
        //王炸
        if (isset($cardValueTime[14]) && isset($cardValueTime[15])) $res[] = array_merge($cardValueTime[14],$cardValueTime[15]);
        return $res;
    }

    /**
     * 提示出牌 三带二
     * @param array $cards
     * @param array $lastCardType
     * @return array
     */
    public function tipThreePair(array $cards,array $lastCardType) :array
    {
        $res = [];
        if ($lastCardType['type'] != self::threePair) return $res;
        $cardValueTime = [];
        foreach ($cards as $card){
            $cardValue = $this->config['value'][substr($card,1)];
            $cardValueTime[$cardValue][] = $card;
        }

        $pairs = [];
        foreach ($cardValueTime as $value => $card){
            if (count($card) < 2) continue;
            for ($i = 0; $i <= count($card) - 2;$i ++){
                $pairs[] = array_slice($card,$i,2);
            }
        }

        foreach ($cardValueTime as $value => $card){
            $countCard = count($card);
            if ($countCard < 3) continue;
            //炸弹
            if ($countCard == 4) $res[] = $card;
            //三张
            if ($countCard >= 3 && $value > $lastCardType['value']) {
                for ($i = 0; $i < $countCard - 2;$i ++){
                    foreach ($pairs as $pair){
                        if ($this->config['value'][substr($pair[0],1)] != $value){
                            $res[] = array_merge(array_slice($card,$i,3),$pair);
                        }
                    }
                }
            }
        }
        //王炸
        if (isset($cardValueTime[14]) && isset($cardValueTime[15])) $res[] = array_merge($cardValueTime[14],$cardValueTime[15]);
        return $res;
    }

    /**
     * 提示出牌 炸弹
     * @param array $cards
     * @param array $lastCardType
     * @return array
     */
    public function tipBomb(array $cards,array $lastCardType) :array
    {
        $res = [];
        if ($lastCardType['type'] != self::bomb) return $res;
        $cardValueTime = [];
        foreach ($cards as $card){
            $cardValue = $this->config['value'][substr($card,1)];
            $cardValueTime[$cardValue][] = $card;
        }

        foreach ($cardValueTime as $value => $card){
            $countCard = count($card);
            if ($countCard < 4) continue;
            //炸弹
            if ($countCard == 4 && $value > $lastCardType['value']) $res[] = $card;
        }
        //王炸
        if (isset($cardValueTime[14]) && isset($cardValueTime[15])) $res[] = array_merge($cardValueTime[14],$cardValueTime[15]);
        return $res;
    }

    /**
     * 提示出牌 四带两个单
     * @param array $cards
     * @param array $lastCardType
     * @return array
     */
    public function tipBombTwoSingle(array $cards,array $lastCardType) :array
    {
        $res = [];

        if ($lastCardType['type'] != self::bombTwoSingle) return $res;
        $cardValueTime = [];
        foreach ($cards as $card){
            $cardValue = $this->config['value'][substr($card,1)];
            $cardValueTime[$cardValue][] = $card;
        }

        foreach ($cardValueTime as $value => $card){
            $countCard = count($card);
            if ($countCard < 4) continue;
            //炸弹
            if ($countCard == 4) $res[] = $card;
            if ($countCard == 4) {
                $twoSingle = [];
                foreach ($cards as $single){
                    if ($this->config['value'][substr($single,1)] == $value) continue;
                    $twoSingle[] = $single;
                }
                for ($i = 0;$i < count($twoSingle) - 1;$i++){
                    $res[] = array_merge(array_slice($twoSingle,$i,2),$card);
                }
            }
        }
        //王炸
        if (isset($cardValueTime[14]) && isset($cardValueTime[15])) $res[] = array_merge($cardValueTime[14],$cardValueTime[15]);

        return $res;
    }

    /**
     * 提示出牌 四带两对
     * @param array $cards
     * @param array $lastCardType
     * @return array
     */
    public function tipBombTwoPair(array $cards,array $lastCardType) :array
    {
        $res = [];

        if ($lastCardType['type'] != self::bombTwoPair) return $res;
        $cardValueTime = [];
        foreach ($cards as $card){
            $cardValue = $this->config['value'][substr($card,1)];
            $cardValueTime[$cardValue][] = $card;
        }

        $pairs = [];
        foreach ($cardValueTime as $value => $card){
            if (count($card) < 2 || count($card) > 3) continue;
            $pairs[] = array_slice($card,0,2);
        }
        foreach ($cardValueTime as $value => $card){
            $countCard = count($card);
            if ($countCard < 4) continue;
            //炸弹
            if ($countCard == 4) $res[] = $card;
            if ($countCard == 4) {
                $twoPair = [];
                foreach ($pairs as $k => $pair){
                    if ($this->config['value'][substr($pair[0],1)] == $value) continue;
                    $twoPair[] = $pair;
                }
                for ($i = 0;$i < count($twoPair) - 1;$i++){
                    $res[] = array_merge(array_merge($twoPair[$i],$twoPair[$i+1]),$card);
                }
            }
        }
        //王炸
        if (isset($cardValueTime[14]) && isset($cardValueTime[15])) $res[] = array_merge($cardValueTime[14],$cardValueTime[15]);

        return $res;
    }
}
