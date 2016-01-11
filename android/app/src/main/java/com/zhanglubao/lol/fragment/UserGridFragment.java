package com.zhanglubao.lol.fragment;

import android.view.View;
import android.widget.GridView;
import android.widget.TextView;

import com.alibaba.fastjson.JSON;
import com.loopj.android.http.TextHttpResponseHandler;
import com.zhanglubao.lol.R;
import com.zhanglubao.lol.adapter.SimpleUserAdapter;
import com.zhanglubao.lol.model.SimpleUserModel;
import com.zhanglubao.lol.network.QTApi;
import com.zhanglubao.lol.network.entity.SimpleUserListEntity;
import com.zhanglubao.pulltorefresh.PullToRefreshBase;
import com.zhanglubao.pulltorefresh.PullToRefreshGridView;

import org.androidannotations.annotations.AfterViews;
import org.androidannotations.annotations.EFragment;
import org.androidannotations.annotations.UiThread;
import org.androidannotations.annotations.ViewById;
import org.apache.http.Header;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by rocks on 15-5-29.
 */
@EFragment(R.layout.fragment_user_gird)
public class UserGridFragment extends  BaseFragment{
    @ViewById(R.id.loadingBar)
    View loadingBar;
    @ViewById(R.id.netWorkError)
    View netWorkErrorView;
    @ViewById(R.id.nav_title)
    TextView titleView;

    String url;

    @ViewById(R.id.userGird)
    PullToRefreshGridView userGird;
    int page = 0;
    boolean isPull = false;

    List<SimpleUserModel> users;
    SimpleUserAdapter userAdapter;

    public static UserGridFragment newInstance(String url) {
        UserGridFragment fragment = new UserGridFragment_();
        fragment.url = url;
        return fragment;
    }

    @AfterViews
    public void afterViews() {
        mPageName=UserGridFragment.class.getName();
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
        userAdapter = new SimpleUserAdapter(getActivity(), users);
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
        if (userModels==null)
        {

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



}
