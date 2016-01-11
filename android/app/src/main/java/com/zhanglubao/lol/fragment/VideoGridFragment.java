package com.zhanglubao.lol.fragment;

import android.view.View;
import android.widget.GridView;

import com.alibaba.fastjson.JSON;
import com.loopj.android.http.TextHttpResponseHandler;
import com.zhanglubao.lol.R;
import com.zhanglubao.lol.adapter.SimpleVideoAdapter;
import com.zhanglubao.lol.model.SimpleVideoModel;
import com.zhanglubao.lol.network.QTApi;
import com.zhanglubao.lol.network.entity.SimpleVideoListEntity;
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
@EFragment(R.layout.fragment_video_grid)
public class VideoGridFragment extends BaseFragment {
    @ViewById(R.id.loadingBar)
    View loadingBar;
    @ViewById(R.id.netWorkError)
    View netWorkErrorView;


    String url;

    @ViewById(R.id.video_gird)
    PullToRefreshGridView videoGird;
    int page = 0;
    boolean isPull = false;

    List<SimpleVideoModel> videos;
    SimpleVideoAdapter videoAdapter;

    public static VideoGridFragment newInstance(String url) {
        VideoGridFragment fragment = new VideoGridFragment_();
        fragment.url = url;
        return fragment;
    }

    @AfterViews
    public void afterViews() {
        mPageName=VideoGridFragment.class.getName();
        videos = new ArrayList<SimpleVideoModel>();
        videoGird.setOnRefreshListener(new PullToRefreshBase.OnRefreshListener2<GridView>() {
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
        videoAdapter = new SimpleVideoAdapter(getActivity(), videos);
        videoGird.setAdapter(videoAdapter);
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
                    SimpleVideoListEntity simpleVideoListEntity= (SimpleVideoListEntity)JSON.parseObject(response, SimpleVideoListEntity.class);
                    recevieData(simpleVideoListEntity.getVideos());

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
        videoGird.onRefreshComplete();
    }

    @UiThread
    public void recevieData(List<SimpleVideoModel> videoModels) {
        if (videoModels==null&&page==0)
        {
            receiveError();
            videoGird.onRefreshComplete();
            return;
        }
        if (videoModels==null)
        {

            videoGird.onRefreshComplete();
            return;
        }
        loadingBar.setVisibility(View.GONE);
        videoGird.onRefreshComplete();
        if (page == 0) {
            videos.clear();
        }
        videos.addAll(videoModels);
        videoAdapter.notifyDataSetChanged();
        videoGird.requestLayout();
    }



}

