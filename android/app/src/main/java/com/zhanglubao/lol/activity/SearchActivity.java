package com.zhanglubao.lol.activity;

import android.support.v4.app.Fragment;
import android.support.v4.view.ViewPager;
import android.widget.TextView;

import com.zhanglubao.lol.R;
import com.zhanglubao.lol.adapter.FragmentAdapter;
import com.zhanglubao.lol.fragment.UserGridFragment_;
import com.zhanglubao.lol.fragment.VideoGridFragment_;
import com.zhanglubao.lol.network.QTUrl;
import com.zhanglubao.lol.view.widget.ViewPagerIndicator;

import org.androidannotations.annotations.AfterViews;
import org.androidannotations.annotations.Click;
import org.androidannotations.annotations.EActivity;
import org.androidannotations.annotations.Extra;
import org.androidannotations.annotations.ViewById;

import java.util.ArrayList;
import java.util.Arrays;
import java.util.List;

/**
 * Created by rocks on 15-7-9.
 */
@EActivity(R.layout.activity_search)
public class SearchActivity extends BaseFragmentActivity {

    @Extra("keyword")
    String keyword;
    @ViewById(R.id.top_indicator)
    ViewPagerIndicator viewPagerIndicator;
    @ViewById(R.id.top_pager)
    ViewPager viewPager;
    @ViewById(R.id.nav_title)
    TextView titleView;

    @AfterViews
    public void afterViews() {
        titleView.setText(keyword);
        List<String> items = Arrays.asList(this.getResources().getStringArray(R.array.tab_search_detail));

        viewPagerIndicator.initSubView(items);

        List<Fragment> fragments = new ArrayList<Fragment>();
        String video_url = QTUrl.search_video_url + keyword;
        String user_url = QTUrl.search_user_url + keyword;
        fragments.add(VideoGridFragment_.newInstance(video_url));
        fragments.add(UserGridFragment_.newInstance(user_url));
        FragmentAdapter fragmentAdapter = new FragmentAdapter(getSupportFragmentManager(), viewPager, fragments);
        viewPager.setAdapter(fragmentAdapter);
        viewPagerIndicator.setViewPager(viewPager);


    }

    @Click(R.id.nav_back_btn)
    public void backBtn() {
            finish();
    }

}
