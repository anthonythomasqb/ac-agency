import React from 'react';

const Movie = ({ movie, onCloseModal }) => (
    <div id="MovieModal">
        <div className="float-end"><button className="btn btn-warning" onClick={onCloseModal}>X</button></div>
        <div className="row pb-3">
            <div className="col-12"><h1>{movie.title}</h1></div>
            <div className="col-4 text-center"><img className="img-fluid" src={movie.image} alt={movie.title} /></div>
            <div className="col-8"><p>{movie.description}</p></div>
        </div>
    </div>
);

export default Movie;
