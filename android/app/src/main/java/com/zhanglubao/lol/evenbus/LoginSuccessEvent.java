package com.zhanglubao.lol.evenbus;

import com.zhanglubao.lol.model.SimpleUserModel;

/**
 * Created by rocks on 15-6-17.
 */
public class LoginSuccessEvent {
    SimpleUserModel user;

    public LoginSuccessEvent(SimpleUserModel user) {
        this.user = user;
    }

    public SimpleUserModel getUser() {
        return user;
    }

    public void setUser(SimpleUserModel user) {
        this.user = user;
    }
}
