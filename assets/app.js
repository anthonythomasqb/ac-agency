/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

import React from 'react';
import ReactDOM from 'react-dom';

import Movie from "./Components/Movie";
import MovieModal from "./Components/MovieModal";

class App extends React.Component {
    constructor() {
        super();

        this.state = {
            movies: [],
            openMovieDetail: false,
            searchMovieField: "",
            selectedMovie: null,
        };
    }

    componentDidMount() {
        fetch('http://localhost/index.php/movies/')
            .then(response => response.json())
            .then(movies => {
                this.setState({
                    movies
                });
            });
    }

    onOpenModal = i => {
        this.setState({
            openMovieDetail: true,
            selectedMovie: i // When a post is clicked, mark it as selected
        });
        document.body.classList.add('modal-open');
    };

    onCloseModal = () => {
        this.setState({
            openMovieDetail: false,
            selectedMovie: null
        });
        document.body.classList.remove('modal-open');
    };

    handleChangeSearchMovieField = (event) => {
        this.setState({
            searchMovieField: event.target.value
        });
    };

    renderMovies = () => {
        return (
            <div className="row">
                <input type="text"
                       onChange={this.handleChangeSearchMovieField}
                       value={this.state.searchMovieField}
                       className="form-control"
                       placeholder="Search a movie (title, category, description) ..." />
                {this.state.movies.map(
                    (movie) => (
                        <Movie
                            key={movie.id}
                            movie={movie}
                            isModalOpened={this.state.selectedMovie !== null}
                            searchMovieField={this.state.searchMovieField}
                            onOpenModal={this.onOpenModal}
                        >
                        </Movie>
                    )
                )}
            </div>
        );
    }

    renderModal = () => {
        if (this.state.selectedMovie !== null) {
            const movie = this.state.movies.find(el => el.id === this.state.selectedMovie);

            return (
                <MovieModal
                    movie={movie}
                    onCloseModal={this.onCloseModal}
                >
                </MovieModal>
            );
        }
    }

    render() {
        return (
            <div>
                {this.renderMovies()}
                <div className={this.openMovieDetail === false ? 'd-none' : ''}>
                    {this.renderModal()}
                </div>
            </div>
        );
    }
}

ReactDOM.render(<App />, document.getElementById('Movies'));
