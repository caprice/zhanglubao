package com.zhanglubao.lol.activity;

import android.content.Intent;
import android.os.Bundle;
import android.os.Handler;
import android.view.ViewGroup;

import com.zhanglubao.lol.R;

import org.androidannotations.annotations.AfterViews;
import org.androidannotations.annotations.EActivity;
import org.androidannotations.annotations.ViewById;

import io.vov.vitamio.Vitamio;

/**
 * Created by rocks on 15-7-15.
 */

@EActivity(R.layout.activity_splash)
public class SplashActivity extends BaseFragmentActivity {
    private static final long SPLASH_SCREEN_DELAY = 2000;
    @ViewById(R.id.ad_container)
    ViewGroup adContainer;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        isFull=false;
        super.onCreate(savedInstanceState);
        Vitamio.isInitialized(getApplicationContext());
    }


    @AfterViews
    public void afterView() {
        new Handler().postDelayed(new Runnable() {
            @Override
            public void run() {


                Intent mainIntent = new Intent().setClass(
                        SplashActivity.this, MainActivity_.class);
                startActivity(mainIntent);
                finish();
            }
        }, SPLASH_SCREEN_DELAY);
    }

    @Override
    public void onBackPressed() {
        return;
    }
}
