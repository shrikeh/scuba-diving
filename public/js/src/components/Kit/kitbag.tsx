"use strict";

import React from "react";
import {KitBag} from "@app/modules/KitBag";

export function withKitBag<Component>(kitBag: KitBag) {
  return class extends React.Component {
    constructor(props) {
      super(props);
      this.handleChange = this.handleChange.bind(this);
      this.state = {
        data: selectData(kitBag, props)
      };
    }

    componentDidMount() {
      // ... that takes care of the subscription...
      kitBag.addChangeListener(this.handleChange);
    }

    componentWillUnmount() {
      kitBag.removeChangeListener(this.handleChange);
    }

    handleChange() {
      this.setState({
        data: selectData(kitBag, this.props)
      });
    }

    render() {
      // ... and renders the wrapped component with the fresh data!
      // Notice that we pass through any additional props
      return <WrappedComponent data={this.state.data} {...this.props} />;
    }
}
