package dtt;

import java.io.IOException;
import java.io.PrintWriter;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;


public abstract class JsonServlet extends HttpServlet {

	private static final long serialVersionUID = 3428210375076295307L;

	protected final void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		response.setContentType("application/json");
		this.doJson(request, response);
	}

	/**
	 * @see HttpServlet#doPost(HttpServletRequest request, HttpServletResponse response)
	 */
	protected final void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
		response.setContentType("application/json");
		this.doJson(request, response);
	}
	
	protected abstract void doJson(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException;
}
