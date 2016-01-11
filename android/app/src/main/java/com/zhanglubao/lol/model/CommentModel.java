package com.zhanglubao.lol.model;

import java.util.List;

/**
 * Created by rocks on 15-6-18.
 */
public class CommentModel {

    String id;
    String content;
    String uid;
    SimpleUserModel user;
    String praised;
    String create_time;
    List<CommentModel> replylist;

    public String getContent() {
        return content;
    }

    public void setContent(String content) {
        this.content = content;
    }



    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getCreate_time() {
        return create_time;
    }

    public void setCreate_time(String create_time) {
        this.create_time = create_time;
    }

    public String getPraised() {
        return praised;
    }

    public void setPraised(String praised) {
        this.praised = praised;
    }

    public String getUid() {
        return uid;
    }

    public void setUid(String uid) {
        this.uid = uid;
    }

    public SimpleUserModel getUser() {
        return user;
    }

    public void setUser(SimpleUserModel user) {
        this.user = user;
    }

    public List<CommentModel> getReplylist() {
        return replylist;
    }

    public void setReplylist(List<CommentModel> replylist) {
        this.replylist = replylist;
    }
}
