package com.zhanglubao.lol.evenbus;

/**
 * Created by rocks on 15-6-24.
 */
public class CommentEvent {

    String content;
    String videoid;
    String commentid;

    public CommentEvent(String commentid, String content, String videoid) {
        this.commentid = commentid;
        this.content = content;
        this.videoid = videoid;
    }

    public String getContent() {
        return content;
    }

    public void setContent(String content) {
        this.content = content;
    }

    public String getVideoid() {
        return videoid;
    }

    public void setVideoid(String videoid) {
        this.videoid = videoid;
    }

    public String getCommentid() {
        return commentid;
    }

    public void setCommentid(String commentid) {
        this.commentid = commentid;
    }
}
