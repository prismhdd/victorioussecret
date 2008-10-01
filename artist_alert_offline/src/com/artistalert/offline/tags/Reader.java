package com.artistalert.offline.tags;

import java.io.File;
import java.io.FilenameFilter;
import java.io.IOException;
import java.util.ArrayList;
import java.util.Collection;
import java.util.Iterator;

import org.farng.mp3.MP3File;
import org.farng.mp3.TagException;

import com.artistalert.offline.model.Artist;

/**
 * The Reader class reads a directory for MP3 files and is able to return the
 * discovered artists/album
 * 
 * @author anthony
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

	/**
	 * Creates a new reader for the specified directory
	 * 
	 * @param directory
	 */
	public Reader(String directory) {
		this.directory = directory;
	}

	/**
	 * Scans the directory for MP3 files and returns the found artists/albums
	 * 
	 * @return
	 * @throws TagException
	 * @throws IOException
	 */
	public Collection<Artist> scan() throws IOException, TagException {
		final Collection<Artist> artists = new ArrayList<Artist>();
		final Collection<File> mp3Files = getMp3Files(new File(directory));
		final Iterator<File> fileItr = mp3Files.iterator();
		while (fileItr.hasNext()) {
			try {
				final MP3File mp3 = new MP3File(fileItr.next());
				if (mp3.getID3v2Tag() != null)
					System.out.println(mp3.getID3v2Tag().getLeadArtist() + " -" + mp3.getID3v2Tag().getAlbumTitle());
			} catch (TagException te) {
				//TODO 
			} catch(IOException ioe) {
				//TODO
			}
		}
		return artists;
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
	 * 		the collection
	 * @param files
	 * 		the array
	 */
	private void appendFiles(final Collection<File> mp3Files, final File[] files) {
		for (File s : files) {
			mp3Files.add(s);
		}
	}

	public static void main(String[] args) {
		final Reader reader = new Reader(args[0]);
		try {
			reader.scan();
		} catch (IOException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		} catch (TagException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
		}
	}
}
