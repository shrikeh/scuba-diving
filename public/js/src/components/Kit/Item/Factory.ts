"use strict";

import React from "React";
import { KitBag } from "@app/modules/KitBag";

export class Factory{
  constructor(private readonly kitbag: KitBag) {}

  withKitBag<Component>(wrappedComponent: Component) {
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
    };
  }
}

export function withKitBag<Component>(wrappedComponent: Component, kitBag: KitBag) {

  };
}
