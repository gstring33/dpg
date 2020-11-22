import React, {Component} from 'react';

class FormAddItem extends Component {

    constructor(props) {
        super(props);
        this.state={
            id: '',
            title: '',
            description: '',
            link: ''
        }

        this.handleSubmit = this.handleSubmit.bind(this);
        this.handleChange = this.handleChange.bind(this);
    }

    handleSubmit(event) {
        event.preventDefault();

        if(this.state.title === '') {
            this.props.setAlertMessage({type:'error', message:'Der Titel muss korrekt eingegeben werden'})
            return
        }

        let gift = {
            id: Math.floor(Math.random() * 1000000) + 1,
            title: this.state.title,
            description: this.state.description,
            link: this.state.link
        }
        this.resetForm();
        this.props.handleSendGiftData(gift);
    }

    handleChange(event) {
        const target = event.target
        const value = target.value
        const name = target.name

        this.setState({[name]: value})
    }

    resetForm() {
        this.setState({
            id: '',
            title: '',
            description: '',
            link: ''
        });
    }

    render() {
        return <form onSubmit={this.handleSubmit}>
                <div className="form-group">
                    <label htmlFor="title">Title <span className="is-required">*</span></label>
                    <input
                        type="text"
                        placeholder="Ex: ein Buch von Thomas Mann"
                        name="title"
                        className="title form-control"
                        value={this.state.title}
                        onChange={this.handleChange}
                    />
                </div>
                <div className="form-group">
                    <label htmlFor="description">Description</label>
                    <textarea
                        name="description"
                        placeholder="Diese Beschreibung sollte es deinem Partner ermöglichen, deinen Wunsch vollständig zu verstehen."
                        className="description form-control"
                        value={this.state.description}
                        onChange={this.handleChange}
                        rows="4"
                        cols="50">
                </textarea>
                </div>
                <div className="form-group">
                    <label htmlFor="link">Link</label>
                    <input
                        type="text"
                        placeholder="ex: https://amazon.de"
                        name="link"
                        className="link form-control"
                        value={this.state.link}
                        onChange={this.handleChange}
                    />
                </div>
                <button type="submit" className="btn btn-primary mb-2"><i className="fas fa-cart-arrow-down fa-button"></i> Wunsch hinzufügen</button>
                <a href="/" type="button" className="btn btn-secondary mb-2 ml-3"><i className="far fa-arrow-alt-circle-left fa-button"></i> Weiter</a>
            </form>;
    }
}

export default FormAddItem;