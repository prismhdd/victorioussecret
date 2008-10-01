package com.artistalert.offline.model;

import java.util.Collection;

/**
 * This class represents a discovered artist in the user's collection
 * 
 * @author anthony
 * 
 */
public class Artist {
	/** The name of the artist/band */
	private String name;
	/** Names of the Albums that this Artist had made, that the user has */
	private Collection<String> albums;

	public String getName() {
		return name;
	}

	public void setName(String name) {
		this.name = name;
	}

	public Collection<String> getAlbums() {
		return albums;
	}

	public void setAlbums(Collection<String> albums) {
		this.albums = albums;
	}
}
