package com.zhanglubao.lol.activity;

import android.app.Activity;
import android.os.Bundle;

import com.zhanglubao.lol.R;

/**
 * Created by rocks on 14-12-4.
 */
public class BaseActivity extends Activity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);

    }
    @Override
    public void onLowMemory() {					//android系统调用
        super.onLowMemory();
        System.gc();
    }

}
