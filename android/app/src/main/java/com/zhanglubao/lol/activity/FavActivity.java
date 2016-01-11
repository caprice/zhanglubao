package com.zhanglubao.lol.activity;

import android.content.Intent;
import android.view.View;
import android.widget.AdapterView;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;

import com.alibaba.fastjson.JSON;
import com.loopj.android.http.TextHttpResponseHandler;
import com.zhanglubao.lol.R;
import com.zhanglubao.lol.adapter.FavVideoAdapter;
import com.zhanglubao.lol.model.SimpleVideoModel;
import com.zhanglubao.lol.network.QTApi;
import com.zhanglubao.lol.network.QTUrl;
import com.zhanglubao.lol.network.entity.SimpleVideoListEntity;
import com.zhanglubao.lol.util.NetworkUtils;
import com.zhanglubao.lol.util.PlayerUtil;
import com.zhanglubao.pulltorefresh.PullToRefreshBase;
import com.zhanglubao.pulltorefresh.PullToRefreshListView;

import org.androidannotations.annotations.AfterViews;
import org.androidannotations.annotations.Click;
import org.androidannotations.annotations.EActivity;
import org.androidannotations.annotations.ViewById;
import org.apache.http.Header;

import java.util.ArrayList;
import java.util.List;

/**
 * Created by rocks on 15-7-7.
 */
@EActivity(R.layout.activity_fav)
public class FavActivity extends BaseFragmentActivity {

    @ViewById(R.id.pull_list_view)
    PullToRefreshListView listView;
    @ViewById(R.id.loadingBar)
    View loadingBar;
    @ViewById(R.id.netWorkError)
    View netWorkErrorView;
    @ViewById(R.id.edit_button)
    TextView editButton;
    @ViewById(R.id.bottom_area)
    View bottomArea;

    FavVideoAdapter adapter;
    List<SimpleVideoModel> videos = new ArrayList<>();
    List<SimpleVideoModel> delVideos = new ArrayList<>();
    public static boolean mIsEditState = false;


    int page = 0;

    public boolean ismIsEditState() {
        return mIsEditState;
    }

    public void setmIsEditState(boolean mIsEditState) {
        this.mIsEditState = mIsEditState;
    }

    @AfterViews
    public void afterView() {
        adapter = new FavVideoAdapter(this, videos);
        listView.setAdapter(adapter);
        listView.setOnRefreshListener(new PullToRefreshBase.OnRefreshListener2<ListView>() {
            @Override
            public void onPullDownToRefresh(PullToRefreshBase<ListView> refreshView) {
                page = 0;
                getPage();
            }

            @Override
            public void onPullUpToRefresh(PullToRefreshBase<ListView> refreshView) {
                page = page + 1;
                getPage();
            }
        });
        listView.setOnItemClickListener(new AdapterView.OnItemClickListener() {
            @Override
            public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                itemClick((SimpleVideoModel) parent.getAdapter().getItem(position));
            }
        });

    }

    @Override
    protected void onResume() {
        super.onResume();
        if (NetworkUtils.isNetworkAvailable()) {
            page=0;
            getPage();
        }else
        {
            loadingBar.setVisibility(View.GONE);
            netWorkErrorView.setVisibility(View.VISIBLE);
        }
    }

    public void getPage() {
        QTApi.getUrlPage(QTUrl.user_my_fav, page, new TextHttpResponseHandler() {
            @Override
            public void onFailure(int i, Header[] headers, String response, Throwable throwable) {
                receiveError();
            }

            @Override
            public void onSuccess(int i, Header[] headers, String response) {
                SimpleVideoListEntity simpleVideoListEntity = (SimpleVideoListEntity) JSON.parseObject(response, SimpleVideoListEntity.class);
                recevieData(simpleVideoListEntity.getVideos());
            }
        });
    }

    public void receiveError() {
        PlayerUtil.showTips(R.string.net_work_error);
        getFinish();
    }

    public void getFinish() {
        loadingBar.setVisibility(View.GONE);
        netWorkErrorView.setVisibility(View.GONE);
        listView.onRefreshComplete();
    }

    public void recevieData(List<SimpleVideoModel> results) {
        if (page == 0) {
            this.videos = results;
            adapter = new FavVideoAdapter(this, videos);
            listView.setAdapter(adapter);
        } else {
            videos.addAll(results);
            adapter.notifyDataSetChanged();
        }
        getFinish();
    }

    @Override
    public void onDestroy() {
        super.onDestroy();
        mIsEditState = false;
    }



    public void itemClick(SimpleVideoModel videoModel) {
        if (mIsEditState) {
            ImageView imageView = (ImageView) listView.findViewWithTag("fav_" + videoModel.getId());
            if (imageView == null) {
                return;
            }
            if (delVideos.contains(videoModel)) {
                delVideos.remove(videoModel);
                imageView.setImageResource(R.drawable.edit_unselected);
            } else {
                delVideos.add(videoModel);
                imageView.setImageResource(R.drawable.edit_selected);
            }
        }else
        {
            Intent intent = new Intent(this, VideoDetailActivity_.class);
            intent.putExtra("video", videoModel);
             startActivity(intent);
        }
    }



    @Click(R.id.btn_del_select)
    public void delVideos() {
        List<String> list = new ArrayList<>();
        List<SimpleVideoModel> temps=new ArrayList<>();
        for (SimpleVideoModel videoModel : delVideos) {
            list.add(videoModel.getId());
            if (videos.contains(videoModel)) {
                temps.add(videoModel);
            }

        }
        videos.removeAll(temps);
        edit();
        adapter = new FavVideoAdapter(this, videos);
        listView.setAdapter(adapter);

        String[] ids = (String[]) list.toArray(new String[list.size()]);
        QTApi.unfav(ids, new TextHttpResponseHandler() {
            @Override
            public void onFailure(int i, Header[] headers, String s, Throwable throwable) {

                PlayerUtil.showTips(R.string.unfav_fail);

            }

            @Override
            public void onSuccess(int i, Header[] headers, String s) {
                PlayerUtil.showTips(R.string.unfav_success);
            }
        });
    }
    boolean isSelectAll = false;
    @ViewById(R.id.btn_all_select)
    TextView allSelectView;
    @Click(R.id.btn_all_select)
    public void selectAll() {
        if (!isSelectAll) {
            delVideos = videos;
            for (SimpleVideoModel videoModel : videos) {
                ImageView imageView = (ImageView) listView.findViewWithTag("fav_" + videoModel.getId());
                imageView.setImageResource(R.drawable.edit_selected);
            }
            allSelectView.setText(getString(R.string.all_unselect));
            isSelectAll=true;
        }else
        {
            isSelectAll=false;
            delVideos = new ArrayList<>();
            for (SimpleVideoModel videoModel : videos) {
                ImageView imageView = (ImageView) listView.findViewWithTag("fav_" + videoModel.getId());
                imageView.setImageResource(R.drawable.edit_unselected);
            }
            allSelectView.setText(getString(R.string.all_select));
        }
    }

    @Click(R.id.edit_button)
    public void edit() {
        if (mIsEditState) {
            mIsEditState = false;
            delVideos.clear();
            bottomArea.setVisibility(View.GONE);
            editButton.setText(getResources().getString(R.string.edit));
            adapter.notifyDataSetChanged();
        } else {
            mIsEditState = true;
            bottomArea.setVisibility(View.VISIBLE);
            editButton.setText(getResources().getString(R.string.finish));
            adapter.notifyDataSetChanged();
        }

    }

    @Override
    public void onBackPressed() {
        if (mIsEditState)
        {
            edit();
        }else {
            super.onBackPressed();
        }
    }

    @Click(R.id.back_img)
    public  void back()
    {
        finish();
    }
}
