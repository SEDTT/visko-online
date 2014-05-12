package dtt.visualization.servlets;

import java.io.IOException;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import com.google.gson.Gson;

import dtt.JsonServlet;
import dtt.visualization.json.GsonFactory;

/**
 * A JsonServlet that sets up the appropriate gson instance for serializing and
 * deserializing objects for the Visualization subsystem.
 * 
 * @author awknaust
 * 
 */
@SuppressWarnings("serial")
public abstract class VisualizationServlet extends JsonServlet {

	protected Gson gson;

	public VisualizationServlet() {
		super();
		this.gson = new GsonFactory().makeGson();
	}

	@Override
	protected abstract void doJson(HttpServletRequest request,
			HttpServletResponse response) throws ServletException, IOException;

}
