package com.zhanglubao.lol.activity;

import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.Intent;
import android.content.IntentFilter;
import android.os.Handler;
import android.support.v4.view.ViewPager;
import android.widget.TextView;

import com.zhanglubao.lol.R;
import com.zhanglubao.lol.adapter.CachePagerAdapter;
import com.zhanglubao.lol.downloader.AsyncImageLoader;
import com.zhanglubao.lol.downloader.DownloadInfo;
import com.zhanglubao.lol.downloader.DownloadManager;
import com.zhanglubao.lol.downloader.IDownload;
import com.zhanglubao.lol.downloader.OnChangeListener;
import com.zhanglubao.lol.fragment.CachedFragment_;
import com.zhanglubao.lol.fragment.CachingFragment_;
import com.zhanglubao.lol.util.PlayerUtil;
import com.zhanglubao.lol.util.Util;

import org.androidannotations.annotations.AfterViews;
import org.androidannotations.annotations.Click;
import org.androidannotations.annotations.EActivity;
import org.androidannotations.annotations.ViewById;

/**
 * Created by rocks on 15-6-26.
 */
@EActivity(R.layout.activity_cache)
public class CacheActivity extends BaseFragmentActivity {

    @ViewById(R.id.cache_pager)
    ViewPager viewPager;

    @ViewById(R.id.cacheTitleCached)
    TextView cachedTitle;
    @ViewById(R.id.cacheTitleCaching)
    TextView cacheingTitle;

    private DownloadManager download;
    CachePagerAdapter adapter;
    private boolean isFirstStart = true;
    private boolean isNoFrom = false;
    private int selectTab = 0;

    @AfterViews
    public void afterViews() {

        adapter = new CachePagerAdapter(getSupportFragmentManager(), viewPager, CachedFragment_.newInstance(), CachingFragment_.newInstance());
        viewPager.setAdapter(adapter);
        viewPager.setOnPageChangeListener(new ViewPager.OnPageChangeListener() {
            @Override
            public void onPageScrolled(int position, float positionOffset, int positionOffsetPixels) {


            }

            @Override
            public void onPageSelected(int position) {
                setSelect(position);
            }

            @Override
            public void onPageScrollStateChanged(int state) {

            }
        });


        download = DownloadManager.getInstance();
        registBroadCastReciver();

        new Handler().postDelayed(new Runnable() {

            @Override
            public void run() {
                if (Util.hasSDCard()) {
                    download = DownloadManager.getInstance();
                    if (isFirstStart) {
                        isFirstStart = false;
                        if (isNoFrom) {
                            if (download.getDownloadingData() != null
                                    && download.getDownloadingData().size() == 0) {
                                selectTab = 1;
                                switchTab(selectTab);
                                if (download.getDownloadedData().size() == 0) {
                                    PlayerUtil.showTips(R.string.tips_no_cache);
                                }
                            }
                        }
                    }

                    download.setOnChangeListener(new OnChangeListener() {

                        @Override
                        public void onFinish() {
                            if (adapter != null) {
                                adapter.cachedFragment.refresh();
                                adapter.cachingFragment.refresh();
                            }
                        }

                        @Override
                        public void onChanged(DownloadInfo info) {
                            if (adapter != null)
                                adapter.cachingFragment.setUpdate(info);
                        }
                    });

                } else {
                    isFirstStart = false;
                }
            }
        }, 500L);


    }

    private void setSelect(int postion) {
        if (postion == 0) {
            cachedTitle.setTextColor(getResources().getColor(R.color.cache_page_title_selected));
            cacheingTitle.setTextColor(getResources().getColor(R.color.cache_page_title_unselect));
        } else

        {
            cachedTitle.setTextColor(getResources().getColor(R.color.cache_page_title_unselect));
            cacheingTitle.setTextColor(getResources().getColor(R.color.cache_page_title_selected));
        }
    }

    @Override
    public void onDestroy() {
        AsyncImageLoader.getInstance().stop();
        if (broadCastReceiver != null)
            unregisterReceiver(broadCastReceiver);
        if (download != null) {
            download.setOnChangeListener(null);
        }
        adapter = null;
        super.onDestroy();
    }


    private BroadcastReceiver broadCastReceiver = new BroadcastReceiver() {

        @Override
        public void onReceive(Context context, Intent intent) {
            final String action = intent.getAction();
            if (action.equals(DownloadManager.ACTION_DOWNLOAD_FINISH)) {

            } else if (action.equals(DownloadManager.ACTION_SDCARD_CHANGED)) {
                adapter.cachedFragment.refresh();
                adapter.cachingFragment.refresh();

            } else if (action
                    .equals(DownloadManager.ACTION_SDCARD_PATH_CHANGED)) {

            } else if (action.equals(DownloadManager.ACTION_THUMBNAIL_COMPLETE)) {
                adapter.cachedFragment.refresh();
                adapter.cachingFragment.refresh();
            } else if (action
                    .equals(DownloadManager.ACTION_CREATE_DOWNLOAD_ALL_READY)) {
                boolean value = intent.getBooleanExtra(
                        IDownload.KEY_CREATE_DOWNLOAD_IS_NEED_REFRESH, true);
                if (value)
                    adapter.cachingFragment.refresh();
            }
        }
    };

    private void registBroadCastReciver() {
        IntentFilter f = new IntentFilter();
        f.addAction(DownloadManager.ACTION_SDCARD_CHANGED);
        f.addAction(DownloadManager.ACTION_SDCARD_PATH_CHANGED);
        f.addAction(DownloadManager.ACTION_THUMBNAIL_COMPLETE);
        f.addAction(DownloadManager.ACTION_DOWNLOAD_FINISH);
        f.addAction(DownloadManager.ACTION_CREATE_DOWNLOAD_ALL_READY);
        registerReceiver(broadCastReceiver, f);
    }

    private void switchTab(int tab) {
        viewPager.setCurrentItem(tab);
    }

    @Click(R.id.cacheTitleCached)
    public void clickCached() {
        switchTab(0);
    }

    @Click (R.id.cacheTitleCaching)
    public void clickCaching() {
        switchTab(1);
    }


    @Click(R.id.cache_back)
    public void back() {
        finish();
    }
}
