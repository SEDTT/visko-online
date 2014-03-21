package dtt.visualization;


import org.joda.time.DateTime;
import org.joda.time.Period;

import java.util.Hashtable;
import java.util.Map.Entry;
import java.util.Set;

import edu.utep.trustlab.visko.execution.PipelineExecutorJob;

public class PipelineJobTable {

		/**
		 * Responsible for examining entries in the parents hashtable, and removing
		 * ones that have not been accessed in a long time.
		 * 
		 * @author awknaust
		 *
		 */
		private class PipelineJobTableCleaner implements Runnable{

			@Override
			public void run() {
				Hashtable<Integer, PipelineJobWrapper> pjtable = PipelineJobTable.this.table;
				
				Set<Entry<Integer, PipelineJobWrapper>> entrys = pjtable.entrySet();
				
				DateTime now = new DateTime();
				for (Entry<Integer, PipelineJobWrapper> e : entrys){
					DateTime atime = e.getValue().getLastAccessTime();
					if(now.isAfter(atime.plus(PipelineJobTable.MAX_LIVE))){
						pjtable.remove(e.getKey());
					}
				}
				
				PipelineJobTable.this.updateCleanTime();
				PipelineJobTable.this.setIsCleaning(false);
			}
			
		}
		
		/**
		 * A simple wrapper around a pipelinejob that keeps track of when
		 * the job was last accessed.
		 * @author awknaust
		 *
		 */
		private class PipelineJobWrapper {
			protected DateTime lastAccessTime;
			protected PipelineExecutorJob job;
		
			/**
			 * Create a new PipelineJob wrapper with creation time as now
			 */
		public PipelineJobWrapper(PipelineExecutorJob job){
			this.job = job;
			this.updateAccessTime();
		}
		
		public DateTime getLastAccessTime(){
			return this.lastAccessTime;
		}
		
		public PipelineExecutorJob getJob(){
			return this.job;
		}
		
		/**
		 * Update last access time to now
		 */
		public void updateAccessTime(){
			this.lastAccessTime = new DateTime(); //now
		}

	}

		/* Not safe to access any of these fields asynchronously */
		private Hashtable<Integer, PipelineJobWrapper> table;
		private boolean isCleaning = false;
		private DateTime nextCleanTime;
		private static final Period CLEAN_INTERVAL = new Period(1, 0, 0, 0); //1 hour
		private static final Period MAX_LIVE = new Period(0, 10, 0, 0); //10 minutes
		
		public PipelineJobTable(){
			this.table = new Hashtable<Integer, PipelineJobWrapper>();
			this.updateCleanTime();
		}
		
		/**
		 * Stores a Pipeline job and associated ID. Initiates cleaning if necessary
		 * 
		 * @param id
		 * @param job
		 */
		public synchronized void put(int id, PipelineExecutorJob job){
			this.table.put(id, new PipelineJobWrapper(job));
			
			//start a cleaning phase if necessary.
			if(!this.isCleaning && this.nextCleanTime.isBeforeNow()){
				this.setIsCleaning(true);
				
				//start a new thread to clean old entries from the table
				new PipelineJobTableCleaner().run();
			}
		}
		
		/**
		 * Gets a pipeline execution job by ID, updating the access time. 
		 * 
		 * @param id the ID of the pipelineExecution Job
		 * @return the pipeline execution job associated with the ID
		 * TODO what if it isn't there?!?!
		 */
		public PipelineExecutorJob get(int id){
			PipelineJobWrapper jw = this.table.get(id);
			jw.updateAccessTime();
			return jw.getJob();
		}
		
		public boolean containsKey(int id){
			return this.table.containsKey(id);
		}
		
		
		private synchronized void setIsCleaning(boolean value){
			this.isCleaning = value;
		}
		
		private synchronized void updateCleanTime(){
			this.nextCleanTime = new DateTime().plus(CLEAN_INTERVAL);
		}
		
		
}
