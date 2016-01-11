package com.zhanglubao.lol.fragment;

import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.view.View;
import android.widget.ImageView;
import android.widget.ListView;
import android.widget.TextView;

import com.zhanglubao.lol.R;
import com.zhanglubao.lol.adapter.CachingVideoAdapter;
import com.zhanglubao.lol.downloader.DownloadInfo;
import com.zhanglubao.lol.downloader.DownloadManager;
import com.zhanglubao.lol.util.PlayerUtil;
import com.zhanglubao.lol.util.Util;

import org.androidannotations.annotations.AfterViews;
import org.androidannotations.annotations.Background;
import org.androidannotations.annotations.Click;
import org.androidannotations.annotations.EFragment;
import org.androidannotations.annotations.ItemClick;
import org.androidannotations.annotations.ViewById;

import java.util.ArrayList;
import java.util.Collections;
import java.util.Iterator;
import java.util.List;
import java.util.Map;

/**
 * Created by rocks on 15-6-26.
 */
@EFragment(R.layout.fragment_caching)
public class CachingFragment extends BaseFragment {
    @ViewById(R.id.listview)
    ListView listView;
    @ViewById(R.id.loadingBar)
    View loadingBar;
    @ViewById(R.id.cache_layout)
    View cacheLayout;


    private CachingVideoAdapter adapter;
    public static boolean mIsEditState = false;

    private boolean needwait = true;
    private DownloadManager download;
    private ArrayList<DownloadInfo> downloadingInfos;
    private ArrayList<DownloadInfo> delInfos = new ArrayList<DownloadInfo>();

    private Handler handler = new Handler() {

        @Override
        public void handleMessage(Message msg) {
            getData();
            if (adapter == null) {
                adapter = new CachingVideoAdapter(getActivity(),
                        downloadingInfos, listView);
                listView.setAdapter(adapter);
            } else {
                adapter.setData(downloadingInfos);
                adapter.notifyDataSetChanged();
            }
        }

    };

    @AfterViews
    public void afterView() {
        download = DownloadManager.getInstance();

    }

    @Override
    public void onActivityCreated(Bundle s) {
        super.onActivityCreated(s);
        if (s != null) {
            if (s.containsKey("downloading_editable"))
                if (s.containsKey("downloading_needwait"))
                    needwait = s.getBoolean("downloading_needwait");
        }

    }

    @Override
    public void onResume() {
        if (needwait) {
            handler.sendEmptyMessageDelayed(0, 100L);
            needwait = false;
        } else
            handler.sendEmptyMessage(0);
        super.onResume();
    }

    @Override
    public void onSaveInstanceState(Bundle outState) {
        outState.putBoolean("downloading_needwait", needwait);
        super.onSaveInstanceState(outState);
    }


    private void getData() {
        downloadingInfos = new ArrayList<DownloadInfo>();
        Map<String, DownloadInfo> map = download.getDownloadingData();
        if (map == null) {
            return;
        }
        Iterator iter = map.entrySet().iterator(); // 获得map的Iterator
        while (iter.hasNext()) {
            Map.Entry entry = (Map.Entry) iter.next();
            downloadingInfos.add((DownloadInfo) entry.getValue());
        }
        DownloadInfo.compareBySeq = false;
        Collections.sort(downloadingInfos);
        loadCompelete();
    }


    public void setUpdate(DownloadInfo info) {
        DownloadInfo infos = null;
        for (int i = 0, n = downloadingInfos.size(); i < n; i++) {
            infos = downloadingInfos.get(i);
            if (info.taskId.equals(infos.taskId)) {
                downloadingInfos.set(i, info);
                break;
            }
        }
        adapter.setUpdate(info);
    }


    public void loadCompelete() {
        if (this.adapter != null) {
            this.adapter.notifyDataSetChanged();
        }
        loadingBar.setVisibility(View.GONE);
        if (downloadingInfos == null || downloadingInfos.size() == 0) {
            cacheLayout.setVisibility(View.GONE);
        } else {
            cacheLayout.setVisibility(View.VISIBLE);
        }
    }

    public static CachingFragment newInstance() {
        CachingFragment fragment = new CachingFragment_();
        return fragment;
    }

    public void notifyData() {
        if (!mIsEditState) {
            delInfos.clear();
            for (DownloadInfo item : downloadingInfos) {
                item.iseditState = 0;
            }
        }
        if (adapter != null) {
            adapter.notifyDataSetChanged();
        }
    }


    @ItemClick(R.id.listview)
    public void itemClick(int position) {
        if (downloadingInfos.size() - 1 < position)
            return;
        final String pageName = "缓存页-正在缓存页";
        DownloadInfo info = downloadingInfos.get(position);
        if (!mIsEditState) {// 非编辑状态时
            int state = info.getState();
            if (state == DownloadInfo.STATE_DOWNLOADING
                    || state == DownloadInfo.STATE_WAITING
                    || state == DownloadInfo.STATE_INIT
                    || state == DownloadInfo.STATE_EXCEPTION) {
                download.pauseDownload(info.taskId);
            } else if (state == DownloadInfo.STATE_PAUSE) {
                if (!Util.hasInternet()) {
                    PlayerUtil.showTips(R.string.tips_no_network);
                    return;
                }
                if (!Util.hasSDCard()) {
                    PlayerUtil.showTips(R.string.download_no_sdcard);
                    return;
                }
                if (Util.isWifi() == false
                        && download.canUse3GDownload() == false) {
                    PlayerUtil.showTips(R.string.download_cannot_ues_3g);
                    return;
                }
                download.startDownload(info.taskId);
            }
        } else {// 编辑状态

            ImageView imageView = (ImageView) listView.findViewWithTag("caching_" + info.videoid);
            if (imageView == null) {
                return;
            }
            if (info.iseditState == 0) {
                info.iseditState = 1;
                delInfos.add(info);
                imageView.setImageResource(R.drawable.edit_selected);
            } else {
                info.iseditState = 0;
                for (DownloadInfo item : delInfos) {
                    if (info.videoid.equals(item.videoid)) {
                        delInfos.remove(item);
                        imageView.setImageResource(R.drawable.edit_unselected);
                    }
                }
            }


        }
    }


    public void refresh() {
        handler.sendEmptyMessageDelayed(0, 500L);
    }


    @ViewById(R.id.bottom_area)
    View bottomArea;
    @ViewById(R.id.cache_edit)
    TextView editButton;
    boolean isSelectAll = false;
    @ViewById(R.id.btn_all_select)
    TextView allSelectView;

    @Click(R.id.btn_all_select)
    public void selectAll() {
        if (!isSelectAll) {
            delInfos = downloadingInfos;
            for (DownloadInfo info : downloadingInfos) {
                ImageView imageView = (ImageView) listView.findViewWithTag("caching_" + info.videoid);
                imageView.setImageResource(R.drawable.edit_selected);
            }
            allSelectView.setText(getString(R.string.all_unselect));
            isSelectAll = true;
            allSelectView.setText(getString(R.string.all_unselect));
        } else {
            isSelectAll = false;
            delInfos = new ArrayList<>();
            for (DownloadInfo info : downloadingInfos) {
                ImageView imageView = (ImageView) listView.findViewWithTag("caching_" + info.videoid);
                imageView.setImageResource(R.drawable.edit_unselected);
            }
            allSelectView.setText(getString(R.string.all_select));
        }
    }



    @Click(R.id.cache_edit)
    public void edit() {
        if (mIsEditState) {
            mIsEditState = false;
            delInfos.clear();
            bottomArea.setVisibility(View.GONE);
            editButton.setText(getResources().getString(R.string.edit));
            adapter.notifyDataSetChanged();
        } else {
            mIsEditState = true;
            bottomArea.setVisibility(View.VISIBLE);
            editButton.setText(getResources().getString(R.string.finish));
            adapter.notifyDataSetChanged();
        }
        loadCompelete();
    }

    @Click(R.id.btn_del_select)
    public void delInfos() {
        List<String> taskids = new ArrayList<>();
        for (DownloadInfo info : delInfos) {
            taskids.add(info.taskId);
            Iterator it = downloadingInfos.iterator();
            while (it.hasNext()) {
                DownloadInfo tempobj = (DownloadInfo) it.next();
                if (tempobj.taskId.equals(info.taskId)) {
                    it.remove();
                }
            }
        }
        delSelects(taskids);
        edit();

    }

    @Background
    public void delSelects(List<String> taskids) {
        if (!isSelectAll) {
            if (taskids != null && taskids.size() > 0) {
                for (String taskid :
                        taskids) {
                    download.deleteDownloading(taskid);
                }

            }

        } else {
            download.deleteAllDownloading();
        }

    }


}
