package dtt;

import java.io.IOException;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import edu.utep.trustlab.visko.sparql.SPARQL_EndpointFactory;


@SuppressWarnings("serial")
public abstract class JsonServlet extends HttpServlet {


	public void init(){
		/* Get the triple store location and set up the Triple Store */
		String tripleStoreLocation = getServletContext().getInitParameter("visko_location");
		SPARQL_EndpointFactory.setUpEndpointConnection(tripleStoreLocation);
	}
	
	protected final void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		response.setContentType("application/json");
		response.setCharacterEncoding("UTF-8");
		request.setCharacterEncoding("UTF-8");
		this.doJson(request, response);
	}

	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */
	protected final void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		response.setContentType("application/json");
		response.setCharacterEncoding("UTF-8");
		request.setCharacterEncoding("UTF-8");
		this.doJson(request, response);
	}
	
	protected abstract void doJson(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException;
}
