package com.zhanglubao.lol.activity;


import android.content.Intent;
import android.os.Handler;
import android.os.Message;
import android.support.v4.app.FragmentTabHost;
import android.view.KeyEvent;
import android.view.LayoutInflater;
import android.view.View;
import android.widget.TabHost.TabSpec;
import android.widget.Toast;

import com.zhanglubao.lol.R;
import com.zhanglubao.lol.config.ZLBConfiguration;
import com.zhanglubao.lol.evenbus.LoginEvent;
import com.zhanglubao.lol.fragment.CategoryFragment_;
import com.zhanglubao.lol.fragment.HomeFragment_;
import com.zhanglubao.lol.fragment.ProfileFragment_;
import com.zhanglubao.lol.fragment.SearchFragment_;
import com.zhanglubao.lol.fragment.TopFragment_;
import com.umeng.socialize.bean.SHARE_MEDIA;

import org.androidannotations.annotations.AfterViews;
import org.androidannotations.annotations.Click;
import org.androidannotations.annotations.EActivity;

import de.greenrobot.event.EventBus;

@EActivity(R.layout.activity_main)
public class MainActivity extends BaseFragmentActivity {


    private FragmentTabHost mTabHost;
    private LayoutInflater layoutInflater;
    boolean isPasue=false;
    boolean isExit;
    @AfterViews
    public void afterViews() {
        if (!EventBus.getDefault().isRegistered(this)) {
            EventBus.getDefault().register(this);
        }
        layoutInflater = LayoutInflater.from(this);
        mTabHost = (FragmentTabHost)

                findViewById(android.R.id.tabhost);

        mTabHost.setup(this, getSupportFragmentManager(), R

                .id.realtabcontent);


        View homeView = layoutInflater.inflate(R.layout.tab_item_home, null);
        TabSpec homeTab = mTabHost.newTabSpec("home").setIndicator(homeView);

        View topView = layoutInflater.inflate(R.layout.tab_item_top, null);
        TabSpec topTab = mTabHost.newTabSpec("top").setIndicator(topView);

        View categoryView = layoutInflater.inflate(R.layout.tab_item_category, null);
        TabSpec categoryTab = mTabHost.newTabSpec("category").setIndicator(categoryView);

        View searchView = layoutInflater.inflate(R.layout.tab_item_search, null);
        TabSpec searchTab = mTabHost.newTabSpec("search").setIndicator(searchView);

        View profileView = layoutInflater.inflate(R.layout.tab_item_profile, null);
        TabSpec profileTab = mTabHost.newTabSpec("profile").setIndicator(profileView);


        mTabHost.addTab(homeTab, HomeFragment_.class, null);
        mTabHost.addTab(categoryTab, CategoryFragment_.class, null);
        mTabHost.addTab(topTab, TopFragment_.class, null);
        mTabHost.addTab(searchTab, SearchFragment_.class, null);
        mTabHost.addTab(profileTab, ProfileFragment_.class, null);




    }

    /**
     * 应用退出时调用此方法
     */

    @Override
    public void onBackPressed() {
        ZLBConfiguration.exit();
        super.onBackPressed();
    }

    public void onEvent(LoginEvent event) {

        SHARE_MEDIA share_media = event.getPlatform();
        if (share_media.equals(SHARE_MEDIA.QQ)) {
            loginQQ();
        } else if (share_media.equals(SHARE_MEDIA.SINA)) {
            loginSina();
        }
    }

    @Click(R.id.search_btn)
    public  void search()
    {
        Intent intent=new Intent(this,SearchEntranceActivity_.class);
        startActivity(intent);
    }
    @Click(R.id.cache_btn)
    public  void cache()
    {
        Intent intent=new Intent(this,CacheActivity_.class);
        startActivity(intent);
    }
    @Click(R.id.fav_btn)
    public void fav()
    {
        Intent intent=new Intent(this,FavActivity_.class);
        startActivity(intent);
    }

    @Override
    protected void onResume() {
        super.onResume();
        isPasue=false;
    }

    @Override
    protected void onPause() {
        super.onPause();
        isPasue=true;
    }

    @Override
    public boolean onKeyDown(int keyCode, KeyEvent event) {

        if (keyCode == KeyEvent.KEYCODE_BACK) {
            exit();
            return false;
        }
        return super.onKeyDown(keyCode, event);
    }

    Handler mHandler = new Handler() {
        @Override
        public void handleMessage(Message msg) {
            super.handleMessage(msg);
            isExit = false;
        }
    };
    public void exit() {
        if (!isExit) {
            isExit = true;
            Toast.makeText(getApplicationContext(), getString(R.string.main_page_return_exit), Toast.LENGTH_SHORT).show();
            mHandler.sendEmptyMessageDelayed(0, 2000);
        } else {

            finish();
        }

    }

}
