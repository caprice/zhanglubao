package com.zhanglubao.lol.network.entity;

import com.zhanglubao.lol.model.SimpleUserModel;

/**
 * Created by rocks on 15-6-17.
 */
public class LoginEntity {
    SimpleUserModel user;
    int status;

    public int getStatus() {
        return status;
    }

    public void setStatus(int status) {
        this.status = status;
    }

    public SimpleUserModel getUser() {
        return user;
    }

    public void setUser(SimpleUserModel user) {
        this.user = user;
    }
}
