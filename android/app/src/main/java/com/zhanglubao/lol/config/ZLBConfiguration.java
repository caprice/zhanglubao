package com.zhanglubao.lol.config;

import android.app.Activity;
import android.content.Context;

import com.zhanglubao.lol.util.Profile;

/**
 * Created by rocks on 15-7-11.
 */
public abstract class ZLBConfiguration {

    public static Context context;
    public static ZLBConfiguration instance;

    public ZLBConfiguration(Context applicationContext) {
        instance = this;
        Profile.mContext = applicationContext;
        Profile.DEBUG = false;
        Profile.LOG = false;
        context=applicationContext;

    }

    public static void exit() {

    }
    public abstract Class<? extends Activity> getCacheActivityClass();
}
