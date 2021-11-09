import React from 'react';

const Movie = ({ id, title, description, image }) => (
    <div key={id} className="movie card col-md-4" style={{width:200}}>
        <div className="card-body">
            <h4 className="card-title">{title}</h4>
            <p className="card-text">{description}</p>
            <img src={image} />
            <a href="https://jsonplaceholder.typicode.com/posts/" className="btn btn-primary">More Details</a>
        </div>
    </div>
);

export default Movie;
