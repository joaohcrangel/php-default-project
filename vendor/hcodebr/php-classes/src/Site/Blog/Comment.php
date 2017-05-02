<?php

namespace Hcode\Site\Blog;

use \Hcode\Model;
use \Hcode\Site\Blog;

class Comment extends Model {

    public $required = array('idpost', 'idperson', 'descomment', 'inapproved');
    protected $pk = "idcomment";

    public function get(){

        $args = func_get_args();
        if(!isset($args[0])) throw new Exception($this->pk." não informado");

        $this->queryToAttr("CALL sp_blogcomments_get(".$args[0].");");
                
    }

    public function save():int
    {

        if($this->getChanged() && $this->isValid()){

            $this->queryToAttr("CALL sp_blogcomments_save(?, ?, ?, ?, ?, ?, ?);", array(
                $this->getidcomment(),
                $this->getidcommentfather(),
                $this->getidpost(),
                $this->getidperson(),
                $this->getdescomment(),
                $this->getinapproved(),
                $this->getnrsubcomments()
            ));

            return $this->getidcomment();

        }else{

            return 0;

        }
        
    }

    public function remove():bool
    {

        $this->proc("sp_blogcomments_remove", array(
            $this->getidcomment()
        ));

        return true;
        
    }

    public static function getCommentsHTML(Comment $commentFather, Comments $commentsAll){

        $roots = $commentsAll->filter('idcommentfather', $commentFather->getidcomment());

        $html = '';

        if($roots->getSize() > 0){

            if($commentFather->getidcomment() === 0){
                $html = '<ol class="commentlist clearfix">';
                $html .= '<li class="comment even thread-even">';
            }else{
                $html = '<ul class="children">';
                $html .= '<li class="comment byuser comment-author-_smcl_admin odd alt" style>';
            }

            foreach ($roots->getItens() as $comment) {
                $html .= '
                    <div class="comment-wrap clearfix">

                        <div class="comment-meta">

                            <div class="comment-author vcard">

                                <span class="comment-avatar clearfix">
                                <img alt="" src="http://0.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=60" class="avatar avatar-60 photo avatar-default" height="60" width="60" /></span>
                            </div>

                        </div>

                        '.(($commentFather->getidcomment() === 0) ? '<div class="comment-content clearfix">' : '<div class="comment-content clearfix" style="padding: 0 0 0 30px;">').'

                            <div class="comment-author">'.$comment->getdesperson().'<span><a href="#">'.$comment->getdesdtregister().'</a></span></div>

                                <p>'.$comment->getdescomment().'</p>

                                <a class="comment-reply-link" href="#""><i class="icon-reply"></i></a>

                            </div>

                            <div class="clear"></div>

                        </div>

                        '.(($comment->getnrsubcomments() > 0) ? Comment::getCommentsHTML($comment, $commentsAll) : '').'
                    </div>
                ';

                $html .= '</li>';

                unset($comment);

            }

            if($commentFather->getidcomment() === 0){
                $html .= '</ol>';
            }else{
                $html .= '</ul>';
            }               

        }

        return $html;

    }

}

?>