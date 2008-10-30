package com.artistalert.offline.tags;

import java.io.File;
import java.io.FilenameFilter;
import java.io.IOException;
import java.io.UnsupportedEncodingException;
import java.util.ArrayList;
import java.util.Collection;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;

import javax.swing.JProgressBar;

import org.jaudiotagger.audio.AudioFileIO;
import org.jaudiotagger.audio.exceptions.CannotReadException;
import org.jaudiotagger.audio.exceptions.InvalidAudioFrameException;
import org.jaudiotagger.audio.exceptions.ReadOnlyFileException;
import org.jaudiotagger.audio.mp3.MP3File;
import org.jaudiotagger.tag.TagException;

/**
 * The Reader class reads a directory for MP3 files and is able to return the
 * discovered artists/album
 * 
 * @author anthony
 * 
 * 	modified to test sending data between frames
 * @author Woojoon
 * 
 */
public class Reader {

	/** Directory we will be traversing */
	private String directory;
	/** Filter that only includes directories */
	private final FilenameFilter dirFilter = new FilenameFilter() {
		public boolean accept(File dir, String name) {
			return new File(dir.getAbsolutePath() + File.separator + name)
					.isDirectory();
		}
	};
	/** Filter that only includes mp3 files */
	private final FilenameFilter mp3Filter = new FilenameFilter() {
		public boolean accept(File dir, String name) {
			return name.toLowerCase().endsWith(".mp3");
		}
	};

	final Map<String, Collection<String>> artists;

	/**
	 * Creates a new reader for the specified directory
	 * 
	 * @param directory
	 */
	public Reader(String directory) {
		this.directory = directory;
		artists = new HashMap<String, Collection<String>>();
	}

	/**
	 * Scans the directory for MP3 files and returns the found artists/albums
	 * 
	 * @return a map with keys as Artist/Band names, and the values as the
	 *  artist names
	 * @throws TagException
	 * @throws IOException
	 */
	public Map<String, Collection<String>> scan(final JProgressBar barProgress) {

		final Collection<File> mp3Files = getMp3Files(new File(directory));
		final Iterator<File> fileItr = mp3Files.iterator();
		barProgress.setMinimum(0);
		barProgress.setMaximum(mp3Files.size());
		barProgress.setValue(0);
		while (fileItr.hasNext()) {
			barProgress.setValue(barProgress.getValue() + 1);
			barProgress.setStringPainted(true);
			try {
				final MP3File mp3 = (MP3File) AudioFileIO.read(fileItr.next());
				final String album = getAlbum(mp3).trim();
				final String artist = getArtist(mp3).trim();
				if (!album.isEmpty() && !artist.isEmpty()) {
					if (artists.containsKey(artist)) {
						if (!artists.get(artist).contains(album))
							artists.get(artist).add(album);
					} else {
						final Collection<String> albums = new ArrayList<String>();
						albums.add(album);
						artists.put(artist, albums);
					}
				}
			} catch (IOException ioe) {
				// Skip any errors
				// ioe.printStackTrace();
			} catch (CannotReadException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			} catch (ReadOnlyFileException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			} catch (InvalidAudioFrameException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			} catch (TagException e) {
				// TODO Auto-generated catch block
				e.printStackTrace();
			}
		}
		printArtists(artists);
		return artists;
	}

	/**
	 * Prints the artists/albums that were found
	 * 
	 * @param artists
	 *      the found artists/albums
	 */
	private void printArtists(final Map<String, Collection<String>> artists) {
		final Iterator<String> artistItr = artists.keySet().iterator();
		while (artistItr.hasNext()) {
			final String artist = artistItr.next();
			System.out.println(artist);
			final Collection<String> albums = artists.get(artist);
			final Iterator<String> albumItr = albums.iterator();
			while (albumItr.hasNext()) {
				System.out.println("\t" + albumItr.next());
			}
		}
	}

	/**
	 * Returns the artist extracted from the mp3 file's tags
	 * 
	 * @param mp3
	 *      the mp3 file we want the tags from
	 * @return the artist name
	 */
	private String getArtist(final MP3File mp3) {
		if (mp3.hasID3v2Tag()) {
			return mp3.getID3v2Tag().getFirstArtist();
		} else if (mp3.hasID3v1Tag())
			return mp3.getID3v1Tag().getFirstArtist();
		else
			return "";
	}

	/**
	 * Returns the album extracted from the mp3 file's tag
	 * 
	 * @param mp3
	 *      the mp3 file we want the tags from
	 * @return the album
	 */
	private String getAlbum(final MP3File mp3) {
		if (mp3.getID3v2Tag() != null)
			return mp3.getID3v2Tag().getFirstAlbum();
		else if (mp3.getID3v1Tag() != null)
			return mp3.getID3v1Tag().getFirstAlbum();
		else
			return "";
	}

	/**
	 * Finds all the mp3 files recursively in the directory
	 * 
	 * @return a list of those files
	 */
	private Collection<File> getMp3Files(final File directory) {
		final Collection<File> mp3Files = new ArrayList<File>();
		final File[] subDirs = directory.listFiles(dirFilter);
		for (File dir : subDirs) {
			mp3Files.addAll(getMp3Files(dir));
		}
		appendFiles(mp3Files, directory.listFiles(mp3Filter));
		return mp3Files;
	}

	/**
	 * Adds an array to a collection
	 * 
	 * @param directories
	 *       the collection
	 * @param files
	 *       the array
	 */
	private void appendFiles(final Collection<File> mp3Files, final File[] files) {
		for (File s : files) {
			mp3Files.add(s);
		}
	}

	// public static void main(String[] args) {
	// final Reader reader = new Reader(args[0]);
	// reader.scan();
	// }
}
