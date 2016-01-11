package com.zhanglubao.lol.network.entity;

import com.zhanglubao.lol.model.SimpleUserModel;
import com.zhanglubao.lol.model.SimpleVideoModel;

import java.util.List;

/**
 * Created by rocks on 15-6-2.
 */
public class SearchIndexEntity {
    List<SimpleUserModel> users;
    List<SimpleVideoModel> videos;

    public List<SimpleUserModel> getUsers() {
        return users;
    }

    public void setUsers(List<SimpleUserModel> users) {
        this.users = users;
    }

    public List<SimpleVideoModel> getVideos() {
        return videos;
    }

    public void setVideos(List<SimpleVideoModel> videos) {
        this.videos = videos;
    }
}
