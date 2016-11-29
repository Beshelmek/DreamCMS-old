<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stat extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();

        require APPPATH . 'third_party/ChartJS.php';
        require APPPATH . 'third_party/ChartJS_Line.php';
        require APPPATH . 'third_party/ChartJS_Pie.php';
        ChartJS::addDefaultColor(array('fill' => 'rgba(46,204,113,.8)', 'stroke' => '#2ecc71', 'point' => '#2ecc71', 'pointStroke' => '#2ecc71'));
    }

    private function getDailyOnlineChart(){
        $servers = $this->server->getList();
        //Дневной онлайн
        $dailyonline = new ChartJS_Line('online', 500, 300, array(), array());

        $arrlabels = $arrline = $stat = array();

        foreach($servers as $servername){
            $q = $this->db->get_where('dc_stat', array('name' => $servername,'time >' => (time() - 86400)));
            foreach ($q->result_array() as $row)
            {
                $arrlabels[$servername][] = date('d.m.y H:i', $row['time']);
                $arrline[$servername][] = $row['count'];
            }

            $dailyonline->addLine($arrline[$servername], array('label' => $servername, 'borderColor' => $this->stringToColorCode($servername)), $servername);
            $dailyonline->addLabels($arrlabels[$servername]);
        }

        return $dailyonline;
    }

    private function getMountlyOnlineChart(){
        $servers = $this->server->getList();
        //Месячный онлайн
        $mountlyonline = new ChartJS_Line('online', 500, 300, array(), array());
        $arrlabels = $arrline = array();

        foreach($servers as $servername){
            $q = $this->db->get_where('dc_stat', array('name' => $servername,'time >' => (time() - 2678400)));

            $array = array();

            foreach ($q->result_array() as $row)
            {
                $mdate = date('d.m', $row['time']);
                $array[$mdate][] = $row['count'];
            }

            foreach (array_keys($array) as $date){
                $values = array_values($array[$date]);
                $arrsum = array_sum($values);
                $arrcount = count($values);
                $arrmiddle = round($arrsum/$arrcount);

                $arrlabels[$servername][] = $date;
                $arrline[$servername][] = $arrmiddle;
            }

            $mountlyonline->addLine($arrline[$servername], array('label' => $servername, 'borderColor' => $this->stringToColorCode($servername)), $servername);
            $mountlyonline->addLabels($arrlabels[$servername]);
        }
        return $mountlyonline;
    }

    private function getTopVotesChart(){
        $arr = $this->db->get_where('dc_logs', array(
            'action' => 'golos_add'
        ))->result_array();

        $tops = array();
        foreach ($arr as $action){
            $params = json_decode($action['params'], true);
            $top = $params['top'];
            if(in_array($top, array_keys($tops))){
                $tops[$top]['count'] += 1;
            }else{
                $tops[$top]['count'] = 1;
            }
        }

        $pie = new ChartJS_Pie('topvotes', 500, 300);
        $labels = array();

        foreach ($tops as $key=>$value){
            $labels[] = $key;
            $pie->addPart($tops[$key]['count'], array('backgroundColor' => $this->stringToColorCode($key)));
        }

        $pie->addLabels($labels);
        return $pie;
    }

    private function getPaymentOperatorChart(){
        $arr = $this->db->get_where('dc_logs', array(
            'action' => 'unitpay_add'
        ))->result_array();

        $tops = array();
        foreach ($arr as $action){
            $params = json_decode($action['params'], true);
            $top = $params['operator'];
            if(in_array($top, array_keys($tops))){
                $tops[$top]['count'] += $params['sum'];
            }else{
                $tops[$top]['count'] = $params['sum'];
            }
        }

        $pie = new ChartJS_Pie('paymentschart', 500, 300);
        $labels = array();

        foreach ($tops as $key=>$value){
            $labels[] = $key;
            $pie->addPart($tops[$key]['count'], array('backgroundColor' => $this->stringToColorCode($key)));
        }

        $pie->addLabels($labels);
        return $pie;
    }

    public function index()
    {
        $this->tpl->compile('stat/online', array(
            'date' => date("d.m.Y H:i:s"),
            'dailyonline' => $this->getDailyOnlineChart(),
            'mountlyonline' => $this->getMountlyOnlineChart(),
            'topvoteschart' => $this->getTopVotesChart(),
            'paymentschart' => $this->getPaymentOperatorChart()
            ), 'Донат группы');
    }

    private function stringToColorCode($str) {
        $code = dechex(crc32($str));
        $code = substr($code, 0, 6);
        return '#'.$code;
    }

}
