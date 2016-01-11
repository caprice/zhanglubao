package com.zhanglubao.lol.network.entity;

import com.zhanglubao.lol.model.SimpleUserModel;

import java.util.List;

/**
 * Created by rocks on 15-6-1.
 */
public class SimpleUserListEntity {
    List<SimpleUserModel> users;
    int status;

    public int getStatus() {
        return status;
    }

    public void setStatus(int status) {
        this.status = status;
    }

    public List<SimpleUserModel> getUsers() {
        return users;
    }

    public void setUsers(List<SimpleUserModel> users) {
        this.users = users;
    }
}
