package com.zhanglubao.lol.model;

import java.io.Serializable;

/**
 * Created by rocks on 15-5-28.
 */
public class VideoModel implements Serializable {
    String id;
    String uid;
    String video_title;
    String video_picture;
    SimpleUserModel user;
    int comment_count;



    public SimpleUserModel getUser() {
        return user;
    }

    public void setUser(SimpleUserModel user) {
        this.user = user;
    }

    public String getVideo_picture() {
        return video_picture;
    }

    public void setVideo_picture(String video_picture) {
        this.video_picture = video_picture;
    }

    public String getVideo_title() {
        return video_title;
    }

    public void setVideo_title(String video_title) {
        this.video_title = video_title;
    }

    public int getComment_count() {
        return comment_count;
    }

    public void setComment_count(int comment_count) {
        this.comment_count = comment_count;
    }

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getUid() {
        return uid;
    }

    public void setUid(String uid) {
        this.uid = uid;
    }
}
