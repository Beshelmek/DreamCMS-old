<?php

class ChartJS_Pie extends ChartJS
{
    protected $_type = 'Pie';
    protected static $_colorsRequired = array('color', 'highlight');
    protected static $_colorsReplacement = array('color' => 'fill', 'highlight' => 'stroke');

    /**
     * Add a set of data
     * @param float $value
     * @param array $options
     * @param null $name Name cas be use to change data / options later
     */
    public function addPart($value, $options = array(), $name = null)
    {
        if (!$name) {
            $name = count($this->_datasets) + 1;
        }
        $this->_datasets[$name]['value'] = $value;
        $this->_datasets[$name]['options'] = $options;
    }

    /**
     * Prepare data (dataset and labels) for the PolarArea
     */
    protected function _renderData()
    {
        $array_data = array();
        $i = 0;

        foreach ($this->_datasets as $part) {

            $this->_completeColors($part['options'], $i);
            $array_data['datasets'][0]['data'][] = $part['value'];
            $array_data['datasets'][0]['backgroundColor'][] = $part['options']['backgroundColor'];

            //$array_data['datasets'][] = $part['options'] + array('label' => $this->_labels[$i]) + array('value' => $part['value']);
            $i++;
        }
        $array_data['labels'] = $this->_labels;
        return ' data-data=\'' . json_encode($array_data) . '\'';
    }
}
