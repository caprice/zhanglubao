package com.zhanglubao.lol.network.entity;

import com.zhanglubao.lol.model.SimpleAlbumModel;

import java.util.List;

/**
 * Created by rocks on 15-6-1.
 */
public class SimpleAlbumListEntity {
    int status;
    List<SimpleAlbumModel> albums;

    public List<SimpleAlbumModel> getAlbums() {
        return albums;
    }

    public void setAlbums(List<SimpleAlbumModel> albums) {
        this.albums = albums;
    }

    public int getStatus() {
        return status;
    }

    public void setStatus(int status) {
        this.status = status;
    }
}
