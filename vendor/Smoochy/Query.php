<?php
/**
 * Smoochy - PHP Template Engine like jQuery
 *
 * PHP version 5
 *
 * @category  Smoochy
 * @package   Smoochy
 * @link      http://bitbucket.org/localdisk/smoochy/
 * @author    Matsuo Masaru a.k.a localdisk
 * @copyright 2009-2010 Matsuo Masaru
 * @license   http://opensource.org/licenses/bsd-license.php New BSD License
 */
require_once 'functions.php';
/**
 * Query
 *
 * @package Smoochy
 * @author  Matsuo Masaru a.k.a localdisk
 */
class Query {
    /**
     * 選択中の要素
     *
     * @var simple_html_dom_node
     */
    private $_elem;
    /**
     * simple_html_dom オブジェクト
     *
     * @var simple_html_dom
     */
    private $_dom;
    /**
     * コンストラクタ
     *
     * @param simple_html_dom $dom
     */
    public function __construct($dom) {
        $this->_dom = $dom;
    }
    /**
     * id から要素を取得します
     *
     * @param  string $id id 属性の値
     * @return Query Query オブジェクト
     */
    public function id($id = null) {
        $this->_elem = $this->_dom->find("#$id", 0);
        if (is_array($this->_elem) && count($this->_elem) === 0) {
            throw new Exception('id is not found.');
        }
        return $this;
    }
    /**
     * 要素を取得/設定します。
     *
     * @param  string|array $key 引数が string の場合は属性値を、連想配列の場合は属性を設定します
     * @param  string $value 属性値
     * @return string|Query Query オブジェクト
     */
    public function attr($key = null, $value = null) {
        if ($value === null) {
            if (is_string($key)) {
                return $this->_elem->$key;
            } elseif (is_array($key)) {
                foreach ($key as $k => $v) {
                    $this->_elem->$k = $v;
                }
                return $this;
            }
        } else {
            $this->_elem->$key = $value;
            return $this;
        }
    }
    /**
     * 属性を消去します
     *
     * @param  string $name 属性名
     * @return Query Query オブジェクト
     */
    public function removeAttr($name = null) {
        if ($name === null) throw new Exception("$name is null");
        $this->_elem->$name = null;
        return $this;
    }
    /**
     * class 属性の値を追加します
     *
     * @param  string $class 追加する class の属性値
     * @return Query Query オブジェクト
     */
    public function addClass($class = null) {
        if ($class === null) throw new Exception('$class is null');
        $clazz = $this->attr('class');
        if ($clazz !== false) {
            $clazz .= ' ';
        }
        $clazz .= $class;
        $this->attr('class', $clazz);
        return $this;
    }
    /**
     * 指定された class 属性値を消去します
     *
     * @param  string $class 消去する class 属性値
     * @return Query Query オブジェクト
     */
    public function removeClass($class = null) {
        if ($class === null) throw new Exception('$class is null');
        $clazz = explode(' ', $this->attr('class'));
        $a = array();
        foreach ($clazz as $c) {
            if (empty($c) || strcmp($class, $c) === 0) {
                continue;
            }
            $a[] = $c;
        }
        $this->attr('class', implode(' ', $a));
        return $this;
    }
    /**
     * class 属性値を切り替えます。
     * 属性値が付加されている場合は消去、付加されていない場合は追加します
     *
     * @param  string $class 切り替える class 属性値
     * @return Query Query オブジェクト
     */
    public function toggleClass($class = null) {
        if ($class === null) throw new Exception('$class is null');
        $clazz = explode(' ', $this->attr('class'));
        foreach ($clazz as $c) {
            if (strcmp($c, $class) === 0) {
                return $this->removeClass($class);
            }
        }
        return $this->addClass($class);
    }
    /**
     * 指定された要素の html を取得/設定します
     *
     * @param  string $val 設定する html 引数を設定しない場合は要素の html を取得します
     * @return string|Query 指定された要素の html|Query オブジェクト
     */
    public function html($val = null) {
        if ($val === null) {
            return $this->_elem->innertext();
        } else {
            $this->clean()->append($val);
        }
        return $this;
    }
    /**
     * 指定された要素の value 値を取得/設定します
     * 当メソッドは引数を自動で escape します
     *
     * @param  string $val 設定する value 引数を設定しない場合は要素の value を取得します
     * @return string|Query 指定された要素の value|Query オブジェクト
     */
    public function val($val = null, $escape = true) {
        if ($val === null) {
            return $this->_elem->value;
        } else {
            if ($escape === true) $val = h($val);
            $this->_elem->value = (string)$val;
        }
        return $this;
    }
    /**
     * 指定された要素の html を取得/設定します
     * 当メソッドは引数を自動で escape します
     *
     * @param  string $val 設定する html 引数を設定しない場合は要素の html を取得します
     * @return string|Query 指定された要素の html|Query オブジェクト
     */
    public function text($val = null, $escape = true) {
        if ($val === null) {
            return $this->_elem->innertext();
        } else {
            if ($escape === true) $val = h($val);
            $this->_elem->innertext = $val;
            return $this;
        }
    }
    /**
     * 指定された要素の中身を削除します
     *
     * @return Query Query オブジェクト
     */
    public function clean() {
        $this->_elem->innertext = '';
        return $this;
    }
    /**
     * 指定された要素の中身に追加します
     *
     * @param  string $str 追加する文字列
     * @return Query
     */
    public function append($str) {
        $this->_elem->innertext .= $str;
        return $this;
    }
    /**
     * 指定された要素の中身に追加します
     * 当メソッドは引数を自動で escape します
     *
     * @param  string $str
     * @return Query
     */
    public function appendText($str, $escape = true) {
        if ($escape === true) $str = h($str);
        $this->_elem->innertext .= $str;
        return $this;
    }
    /**
     * simple_html_dom オブジェクトを取得します
     *
     * @return simple_html_dom simple_html_dom オブジェクト
     */
    public function getDom() {
        return $this->_dom;
    }
    /**
     * 繰り返し処理を行います
     * 
     * @param array $obj 設定するオブジェクト
     */
    public function loop(array $objs) {
        $this->_elem->id = null;
        $outertext = $this->_elem->outertext();
        $this->_elem->outertext = '';
        $title = $this->_getTitle($this->_elem);
        foreach ($objs as $obj) {
            $dom = new simple_html_dom($outertext);
            $this->_elem->outertext .= $this->_renderLoop($title, $dom, $obj);
        }
    }
    /**
     * 他のページクラスをインポートします
     *
     * @param  Page $page ページクラス
     * @return void
     */
    public function import(Page $page) {
        $this->html($page->getDom()->save());
    }
    /**
     * 選択された要素の外側の要素を削除します
     * 例
     * <div id="foo"><p>bar</p></div>
     * $this->id('foo')->dummy()
     * とすると
     * <p>bar</p>
     * になります
     *
     * @return void
     */
    public function dummy() {
        $this->_elem->outertext = $this->_elem->innertext;
    }
    /**
     * デバッグ用メソッド
     * 選択した要素とその子要素を文字列で返します
     * 
     * @return string
     */
    public function debug() {
        return $this->_elem->outertext();
    }
    /**
     * get title attribute
     * 
     * @param  simple_html_dom_node $nodes
     * @return string|array
     */
    private function _getTitle($nodes) {
        if ($nodes->title !== false) return $nodes->title;
        $titles = array();
        foreach ($nodes->children as $node) {
            if ($node->title !== false) {
                $titles[] = $node->title;
            }
        }
        return $titles;
    }
    /**
     * render loop
     * 
     * @param string|array $title
     * @param simple_html_dom $dom
     * @param array|object $obj
     * @return string
     */
    private function _renderLoop($title, $dom, $obj) {
        if (is_string($title)) $title = array($title);
        foreach ($title as $t) {
            $nodes = $dom->find("[title=$t]");
            foreach ($nodes as $node) {
                $node->innertext = is_array($obj) ? $obj[$t] : $obj->$t;
            }
        }
        $str = $dom->save();
        $dom->clear();
        return $str;
    }
}