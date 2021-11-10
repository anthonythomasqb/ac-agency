import React from 'react';

const userId = document.getElementById("user_id").value;

class MovieModal extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        let buttonFavourite;
        if (userId) {
            if(this.props.movie.user_id !== null && this.props.movie.user_id === parseInt(userId)){
                buttonFavourite = <button className="btn btn-danger float-end" onClick={() => this.props.handleAddToFavorite("delete")}>Remove to favorite</button>;
            }else{
                buttonFavourite = <button className="btn btn-warning float-end" onClick={() => this.props.handleAddToFavorite("add")}>Add to favorite</button>;
            }
        } else {
            buttonFavourite = "";
        }

        return (
            <div id="MovieModal">
                <div className="float-end"><button className="btn btn-warning" onClick={this.props.onCloseModal}>X</button></div>
                <div className="row pb-3">
                    <div className="col-12"><h1>{this.props.movie.title}</h1></div>
                    <div className="col-4 text-center"><img className="img-fluid" src={this.props.movie.image} alt={this.props.movie.title} /></div>
                    <div className="col-8">
                        <p>{this.props.movie.description}</p>
                        {buttonFavourite}
                    </div>
                </div>
            </div>
        );
    }
}

export default MovieModal;
