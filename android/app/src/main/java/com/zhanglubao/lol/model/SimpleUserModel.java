package com.zhanglubao.lol.model;

import java.io.Serializable;

/**
 * Created by rocks on 15-5-30.
 */
public class SimpleUserModel implements Serializable {

    String uid;
    String nickname;
    String avatar;

    public String getNickname() {
        return nickname;
    }

    public void setNickname(String nickname) {
        this.nickname = nickname;
    }

    public String getAvatar() {
        return avatar;
    }

    public void setAvatar(String avatar) {
        this.avatar = avatar;
    }

    public String getUid() {
        return uid;
    }

    public void setUid(String uid) {
        this.uid = uid;
    }
}
