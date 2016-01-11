package com.zhanglubao.lol.activity;

import android.content.Intent;
import android.view.View;
import android.widget.GridView;
import android.widget.TextView;

import com.alibaba.fastjson.JSON;
import com.loopj.android.http.TextHttpResponseHandler;
import com.zhanglubao.lol.R;
import com.zhanglubao.lol.adapter.SimpleUserAdapter;
import com.zhanglubao.lol.evenbus.ListEvent;
import com.zhanglubao.lol.model.SimpleUserModel;
import com.zhanglubao.lol.network.QTApi;
import com.zhanglubao.lol.network.entity.SimpleUserListEntity;
import com.zhanglubao.pulltorefresh.PullToRefreshBase;
import com.zhanglubao.pulltorefresh.PullToRefreshGridView;

import org.androidannotations.annotations.AfterViews;
import org.androidannotations.annotations.Click;
import org.androidannotations.annotations.EActivity;
import org.androidannotations.annotations.Extra;
import org.androidannotations.annotations.UiThread;
import org.androidannotations.annotations.ViewById;
import org.apache.http.Header;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by rocks on 15-6-9.
 */
@EActivity(R.layout.activity_user_grid)
public class UserGridActivity extends  BaseFragmentActivity {


    @Extra("title")
    String title;
    @Extra("url")
    String url;


    @ViewById(R.id.loadingBar)
    View loadingBar;
    @ViewById(R.id.netWorkError)
    View netWorkErrorView;

    @ViewById(R.id.nav_title)
    TextView titleView;


    @ViewById(R.id.userGird)
    PullToRefreshGridView userGird;
    int page = 0;
    boolean isPull = false;

    List<SimpleUserModel> users;
    SimpleUserAdapter userAdapter;


    @AfterViews
    public void afterViews() {
        titleView.setText(title);
        users = new ArrayList<SimpleUserModel>();
        userGird.setOnRefreshListener(new PullToRefreshBase.OnRefreshListener2<GridView>() {
            @Override
            public void onPullDownToRefresh(PullToRefreshBase<GridView> refreshView) {
                page = 0;
                isPull = true;
                getData(page);
            }

            @Override
            public void onPullUpToRefresh(PullToRefreshBase<GridView> refreshView) {
                isPull = true;
                page++;
                getData(page);
            }
        });
        userAdapter = new SimpleUserAdapter(this, users);
        userGird.setAdapter(userAdapter);
        getData(page);
    }

    public void getData(int page) {
        if (!isPull) {
            loadingBar.setVisibility(View.VISIBLE);
        }
        QTApi.getUrlPage(url, page, new TextHttpResponseHandler() {


            @Override
            public void onSuccess(int i, Header[] headers, String response) {
                try {
                    SimpleUserListEntity simpleUserListEntity = (SimpleUserListEntity) JSON.parseObject(response, SimpleUserListEntity.class);
                    recevieData(simpleUserListEntity.getUsers());

                } catch (Exception e) {

                    receiveError();
                }
            }

            @Override
            public void onFailure(int i, Header[] headers, String response, Throwable throwable) {
                receiveError();
            }
        });
    }

    public void receiveError() {
        netWorkErrorView.setVisibility(View.VISIBLE);
        userGird.onRefreshComplete();
    }

    @UiThread
    public void recevieData(List<SimpleUserModel> userModels) {
        if (userModels == null) {

            userGird.onRefreshComplete();
            return;
        }
        loadingBar.setVisibility(View.GONE);
        userGird.onRefreshComplete();
        if (page == 0) {
            users.clear();
        }
        users.addAll(userModels);
        userAdapter.notifyDataSetChanged();
        userGird.requestLayout();
    }



    public void onEvent(ListEvent list) {

        Intent intent = new Intent(this, VideoGridActivity_.class);
        intent.putExtra("title", list.getTitle());
        intent.putExtra("url", list.getUrl());
        startActivity(intent);
    }
    @Click(R.id.nav_back_btn)
    public void backBtn() {
        finish();
    }
}

