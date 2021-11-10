import React from 'react';

const bindMovieClass = (movie, isModalOpened, searchMovieField) => {
    let className = "movie card col-4";

    if(isModalOpened){
        className += " modal-open";
    }

    if(searchMovieField === ""){
        return className;
    }

    if(movie.title.toLowerCase().indexOf(searchMovieField.toLowerCase()) === -1
        && movie.category.toLowerCase().indexOf(searchMovieField.toLowerCase()) === -1
        && movie.description.toLowerCase().indexOf(searchMovieField.toLowerCase()) === -1){
        className += " d-none";
    }

    return className
};

const Movie = ({ movie, isModalOpened, onOpenModal, searchMovieField }) => (
    <div className={bindMovieClass(movie, isModalOpened, searchMovieField)} onClick={() => onOpenModal(movie.id)}>
        <img className="card-img-top" src={movie.image} alt={movie.title} />
        <div className="card-body">
            <h5 className="card-title">{movie.title}</h5>
            <em className="card-text">{movie.category}</em>
        </div>
    </div>
);

export default Movie;
