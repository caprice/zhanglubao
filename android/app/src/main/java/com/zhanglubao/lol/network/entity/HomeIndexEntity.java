package com.zhanglubao.lol.network.entity;

import com.zhanglubao.lol.model.SimpleAlbumModel;
import com.zhanglubao.lol.model.SimpleUserModel;
import com.zhanglubao.lol.model.SimpleVideoModel;
import com.zhanglubao.lol.model.SlideModel;

import java.util.List;

/**
 * Created by rocks on 15-5-28.
 */
public class HomeIndexEntity {
    List<SlideModel> slides;
    List<SimpleVideoModel>hotvideos;

    List<SimpleVideoModel>commvideos;
    List<SimpleUserModel>commusers;

    List<SimpleVideoModel>mastervideos;
    List<SimpleUserModel>masterusers;

    List<SimpleVideoModel>albumvideos;
    List<SimpleAlbumModel>videoalbums;

    List<SimpleVideoModel>matchvideos;
    List<SimpleUserModel>matchusers;

    List<SimpleVideoModel>othervideos;


    public List<SimpleUserModel> getCommusers() {
        return commusers;
    }

    public void setCommusers(List<SimpleUserModel> commusers) {
        this.commusers = commusers;
    }

    public List<SimpleVideoModel> getCommvideos() {
        return commvideos;
    }

    public void setCommvideos(List<SimpleVideoModel> commvideos) {
        this.commvideos = commvideos;
    }

    public List<SimpleVideoModel> getHotvideos() {
        return hotvideos;
    }

    public void setHotvideos(List<SimpleVideoModel> hotvideos) {
        this.hotvideos = hotvideos;
    }

    public List<SlideModel> getSlides() {
        return slides;
    }

    public void setSlides(List<SlideModel> slides) {
        this.slides = slides;
    }

    public List<SimpleUserModel> getMasterusers() {
        return masterusers;
    }

    public void setMasterusers(List<SimpleUserModel> masterusers) {
        this.masterusers = masterusers;
    }

    public List<SimpleVideoModel> getMastervideos() {
        return mastervideos;
    }

    public void setMastervideos(List<SimpleVideoModel> mastervideos) {
        this.mastervideos = mastervideos;
    }

    public List<SimpleVideoModel> getAlbumvideos() {
        return albumvideos;
    }

    public void setAlbumvideos(List<SimpleVideoModel> albumvideos) {
        this.albumvideos = albumvideos;
    }

    public List<SimpleAlbumModel> getVideoalbums() {
        return videoalbums;
    }

    public void setVideoalbums(List<SimpleAlbumModel> videoalbums) {
        this.videoalbums = videoalbums;
    }

    public List<SimpleUserModel> getMatchusers() {
        return matchusers;
    }

    public void setMatchusers(List<SimpleUserModel> matchusers) {
        this.matchusers = matchusers;
    }

    public List<SimpleVideoModel> getMatchvideos() {
        return matchvideos;
    }

    public void setMatchvideos(List<SimpleVideoModel> matchvideos) {
        this.matchvideos = matchvideos;
    }

    public List<SimpleVideoModel> getOthervideos() {
        return othervideos;
    }

    public void setOthervideos(List<SimpleVideoModel> othervideos) {
        this.othervideos = othervideos;
    }
}

